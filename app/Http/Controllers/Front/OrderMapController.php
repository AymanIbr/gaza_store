<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class OrderMapController extends Controller
{
    public function show(Order $order)
    {
        return view('website.orders.show', compact('order'));
    }




    //  order pdf

}
