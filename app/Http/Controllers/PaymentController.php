<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class PaymentController extends Controller
{

    protected function getClient()
    {
        $config = config('services.paypal');
        $environment = new SandboxEnvironment($config['client_id'], $config['client_secret']);
        $client = new PayPalHttpClient($environment);

        return $client;
    }

    public function create(Order $order)
    {


        $client = $this->getClient();

        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // \dd($amount);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order->id,
                "amount" => [
                    "value" => $amount,
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => url(route('paypal.cancel')),
                "return_url" => url(route('paypal.callback'))
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            // \dd($response);
            if ($response->statusCode == 201  && isset($response->result)) {
                Session::put('paypal_order_id', $response->result->id);
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            print_r($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $order_id = Session::get('paypal_order_id');
        $request = new OrdersCaptureRequest($order_id);
        $request->prefer('return=representation');
        try {
            $client = $this->getClient();

            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            if ($response->statusCode == 201 && isset($response->result)) {
                if ($response->result->status == 'COMPLETED') {
                    // update order payment status

                    Session::forget('paypal_order_id');
                    return redirect('/');
                }
            }            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            print_r($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }
}
