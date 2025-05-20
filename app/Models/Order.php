<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    //

    // protected $guarded = [];

    protected $fillable = [
        'user_id',
        'payment_method',
        'status',
        'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }

    protected static function booted()
    {
        static::creating(function (Order $order) {
            // 20250001, 20250002
            $order->number = Order::getNextOrderNumber();
        });
    }

    // many to many
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->withPivot([
                'product_name',
                'price',
                'quantity'
            ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id','id')->where('type','billing');
    }

     public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id','id')->where('type','shipping');
    }

    public static function getNextOrderNumber()
    {
        // SELECT MAX(number) FROM orders
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
