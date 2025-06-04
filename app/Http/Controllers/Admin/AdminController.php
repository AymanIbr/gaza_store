<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{

    function index()
    {
        $user_count = User::count();
        $category_count = Category::count();
        $product_count = Product::count();
        $order_count = Order::count();
        return view('dashboard.index',
        compact('user_count','category_count','product_count','order_count'));
    }


    public function profile()
    {
        $admin = Auth::user();
        return view('dashboard.profile', compact('admin'));
    }

    public function profile_save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,svg,jpeg',
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);


        // PHPDoc Comment
        /** @var User $admin */
        $admin = Auth::user();

        $data = [
            'name' => $request->name
        ];

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        if ($request->hasFile('image')) {
            if ($admin->image) {
                File::delete('storage/' . $admin->image->path);
                $admin->image()->delete();
            }
            $path = $request->file('image')->store('uploads', 'custom');
            $admin->image()->create([
                'path' => $path
            ]);
        }


        return redirect()->back();
    }

    function check_password(Request $request)
    {
        return Hash::check($request->password, Auth::user()->password);
    }


    // Settings

    function settings()
    {
        if (Gate::denies('settings')) {
            return abort(403, 'Don\'t have permission to access this page');
        }
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings', compact('settings'));
    }

    function settings_save(Request $request)
    {
        if (Gate::denies('settings')) {
            return abort(403, 'Don\'t have permission to access this page');
        }
        $data = $request->except('_token', '_method', 'site_logo');
        if ($request->hasFile('site_logo')) {
            $data['site_logo'] = $request->file('site_logo')->store('uploads', 'custom');
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate([
                'key' => $key
            ], [
                'value' => $value
            ]);
        }
        flash()->success('Settings saved successfully');
        return redirect()->back();
    }

    function delete_logo()
    {
        Artisan::call('cache:clear');
        Setting::where('key', 'site_logo')->update([
            'value' => null
        ]);
    }


    // Notification

    function orders()
    {
        if (request()->has('id')) {
            $id = request()->id;
            Auth::user()->notifications->find($id)->MarkAsRead();
        }
        return 'order';
    }

    function notifications()
    {
        Auth::user()->notifications->markAsRead();
        return view('dashboard.notifications');
    }



    // Chart Order

    // public function ordersChart(Request $request)
    // {
    //     $group = $request->query('group', 'month');

    //     $query = DB::table('orders')
    //         ->join('order_items', 'orders.id', '=', 'order_items.order_id')
    //         ->select([
    //             DB::raw('COUNT(DISTINCT orders.id) as count'),
    //             DB::raw('SUM(order_items.price * order_items.quantity) as total')])
    //         ->groupBy('label')->orderBy('label');

    //     switch ($group) {
    //         case 'day':
    //             $query->addSelect(DB::raw('DATE(created_at) as label'));
    //             $query->whereDate('created_at', '>=', Carbon::now()->startOfMonth());
    //             $query->whereDate('created_at', '<=', Carbon::now()->endOfMonth());
    //             break;
    //         case 'week':
    //             $query->addSelect(DB::raw('DATE(created_at) as label'));
    //             $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek());
    //             $query->whereDate('created_at', '<=', Carbon::now()->endOfWeek());
    //             break;
    //         case 'year':
    //             $query->addSelect(DB::raw('YEAR(created_at) as label'));
    //             $query->whereYear('created_at', '>=', Carbon::now()->subYears(5)->year);
    //             $query->whereYear('created_at', '<=', Carbon::now()->addYears(4)->year);
    //             break;
    //         case 'month':
    //             $query->addSelect(DB::raw('MONTH(created_at) as label'));
    //             $query->whereDate('created_at', '>=', Carbon::now()->startOfYear());
    //             $query->whereDate('created_at', '<=', Carbon::now()->endOfYear());
    //           /*  $labels = [
    //                 1 => 'Jan',
    //                 'Feb',
    //                 'Mar',
    //                 'Apr',
    //                 'May',
    //                 'Jun',
    //                 'Jul',
    //                 'Aug',
    //                 'Sep',
    //                 'Oct',
    //                 'Nov',
    //                 'Dec'
    //             ];
    //             */
    //         default;
    //     }

    //     // $entries = DB::table('orders')
    //     //     ->join('order_items', 'orders.id', '=', 'order_items.order_id')
    //     //     ->select([
    //     //         // DB::raw('MONTH(orders.created_at) as month'),
    //     //         // DB::raw('YEAR(orders.created_at) as year'),
    //     //         DB::raw($group_col),
    //     //         DB::raw('COUNT(DISTINCT orders.id) as count'),
    //     //         DB::raw('SUM(order_items.price * order_items.quantity) as total')
    //     //     // ])->whereYear('orders.created_at', 2025)
    //     //     // ->groupBy(DB::raw('MONTH(orders.created_at)'))
    //     //     ->groupBy('label')->orderBy('label')
    //     //     ->get();

    //     $entries = $query->get();


    //     $labels = $total = $count = [];

    //     foreach ($entries as $entry) {
    //         $labels[] = $entry->label;
    //         $total[$entry->label] = $entry->total;
    //         $count[$entry->label] = $entry->count;
    //     }

    //     // foreach ($labels as $month => $name) {
    //     //     if (!array_key_exists($month, $count)) {
    //     //         $count[$month] = 0;
    //     //     }

    //     //     if (!array_key_exists($month, $total)) {
    //     //         $total[$month] = 0;
    //     //     }
    //     // }
    //     // ksort($total);
    //     // ksort($count);
    //     return [
    //         'group' => $group,
    //         'labels' => array_values($labels),
    //         'datasets' => [
    //             [
    //                 'label' => 'Total ($)',
    //                 'borderColor' => 'blue',
    //                 'backgroundColor' => 'blue',
    //                 'data' => array_values($total),
    //             ],

    //             [
    //                 'label' => 'Orders #',
    //                 'borderColor' => 'darkgreen',
    //                 'backgroundColor' => 'darkgreen',
    //                 'data' => array_values($count),
    //             ],

    //         ]
    //     ];
    // }

    public function ordersChart(Request $request)
    {
        $group = $request->query('group', 'month');

        $query = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select([
                DB::raw('COUNT(DISTINCT orders.id) as count'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total'),
            ]);

        switch ($group) {
            case 'day':
                $query->addSelect(DB::raw('DATE(orders.created_at) as label'));
                $query->whereDate('orders.created_at', '>=', Carbon::now()->startOfMonth());
                $query->whereDate('orders.created_at', '<=', Carbon::now()->endOfMonth());
                break;

            case 'week':
                $query->addSelect(DB::raw('DATE(orders.created_at) as label'));
                $query->whereDate('orders.created_at', '>=', Carbon::now()->startOfWeek());
                $query->whereDate('orders.created_at', '<=', Carbon::now()->endOfWeek());
                break;

            case 'year':
                $query->addSelect(DB::raw('YEAR(orders.created_at) as label'));
                $query->whereYear('orders.created_at', '>=', Carbon::now()->subYears(5)->year);
                $query->whereYear('orders.created_at', '<=', Carbon::now()->addYears(4)->year);
                break;

            case 'month':
            default:
                $query->addSelect(DB::raw('MONTH(orders.created_at) as label'));
                $query->whereDate('orders.created_at', '>=', Carbon::now()->startOfYear());
                $query->whereDate('orders.created_at', '<=', Carbon::now()->endOfYear());
                break;
        }

        $query->groupBy('label')->orderBy('label');
        $entries = $query->get();

        $labels = $total = $count = [];

        foreach ($entries as $entry) {
            $labels[] = $entry->label;
            $total[$entry->label] = $entry->total;
            $count[$entry->label] = $entry->count;
        }

        return [
            'group' => $group,
            'labels' => array_values($labels),
            'datasets' => [
                [
                    'label' => 'Total ($)',
                    'borderColor' => 'blue',
                    'backgroundColor' => 'rgba(0, 0, 255, 0.6)',
                    'data' => array_values($total),
                ],
                [
                    'label' => 'Orders #',
                    'borderColor' => 'darkgreen',
                    'backgroundColor' => 'rgba(0, 100, 0, 0.6)',
                    'data' => array_values($count),
                ],
            ]
        ];
    }
}
