<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryLocationUpdate;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
        ]);

        $delivery->update([
            'lat' => $request->lat,  // => Y
            'lng' => $request->lng,  // => x
        ]);

        event(new DeliveryLocationUpdate($request->lng, $request->lat));

        // if private channel
        // event(new DeliveryLocationUpdate($delivery, $request->lng, $request->lat));

        return $delivery;
    }
}
