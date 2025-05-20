<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Illuminate\Support\Facades\Notification;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            session()->flash('danger', 'No items in cart');
            return redirect()->route('site.index');
        }

        return view('website.checkout', [
            'cart' => $cart,
            //composer require symfony/intl
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        // dd($request->all());
        $request->validate([
            'addr.billing.first_name' => ['required', 'string', 'max:255'],
            'addr.billing.last_name' => ['required', 'string', 'max:255'],
            'addr.billing.email' => ['required', 'email', 'max:255'],
            'addr.billing.city' => ['required', 'string', 'max:255'],
            'addr.billing.phone' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            foreach ($cart->get() as $item) {
            $product = Product::find($item->product_id);

            if (!$product || $product->quantity < $item->quantity) {
                DB::rollBack();
                return redirect()->back()->with('danger', "For product unavailable quantity: {$product->trans_name}");
            }
        }


            $order = Order::create([
                'user_id' => Auth::id(),
                'payment_method' => 'cod',
            ]);

            // items form cart
            foreach ($cart->get() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }

            // add information customer to orderAddresses
            foreach ($request->post('addr') as $type => $address) {
                $address['type'] = $type;
                $order->addresses()->create($address);
            }


            // update quantity product after checkout
            // UPDATE products SET quantity = quantity - 1

            foreach ($cart->get() as $item) {
                Product::where('id', $item->product_id)
                    ->update([
                        'quantity' => DB::raw("quantity - {$item->quantity}")
                    ]);
            }

            $cart->empty();
            DB::commit();

            // notification
            $user = User::first();
            $productDetails = $cart->get()->map(function ($item) {
                return $item->product->trans_name . ' (x' . $item->quantity . ')';
            })->join(', ');

            $totalPrice = $cart->get()->sum(fn($item) => $item->product->price * $item->quantity);
            // single user
            $user->notify(new NewOrderNotification($user->name, $productDetails, $totalPrice));
            // multi user
            // $user = User::get();
            // Notification::send($user,new NewOrderNotification($user->name, $productDetails, $totalPrice));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        session()->flash('success', 'Order created successfully');
        return redirect()->route('site.index');
    }
}
