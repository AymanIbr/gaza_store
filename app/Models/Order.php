<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    protected $guarded = [];


    function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
