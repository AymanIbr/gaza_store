<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{

    protected $guarded = [];

    public $incrementing = false;

    function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous'
        ]);
    }

    function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    // Events (Observers)
    // php artisan make:observer CartObserver --model=Cart
    // creating => Before implementation, created => After implementation, updating, updated, saving, saved
    // deleting, deleted, restoring, restored

    protected static function booted()
    {
        static::observe(CartObserver::class);
        // static::creating(function (Cart $cart) {
        //     $cart->id = Str::uuid();
        // });
    }
    
}
