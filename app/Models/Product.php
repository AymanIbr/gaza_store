<?php

namespace App\Models;

use App\Traits\Trans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use Trans;

    protected $guarded = [];

    function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategoriez'
        ]);
    }

    // public function variants()
    // {
    //     return $this->hasMany(Variant::class);
    // }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable')->withDefault([
            'path' => 'uploads/' . 'no-image.png'
        ])->where('type', 'main');
    }

    function gallery()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'gallery');
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->where('status', 1)->avg('star');
    }

    public function approvedReviewsCount()
    {
        return $this->reviews()->where('status', 1)->count();
    }

    public function views()
    {
        return $this->hasMany(ProductView::class);
    }

    // function order_details()
    // {
    //     return $this->hasMany(OrderDetail::class);
    // }


    public function getImagePathAttribute()
    {
        $url = asset('assets/img/100x80.svg');
        if ($this->image) {
            $url = asset('storage/' . $this->image->path);
        }
        return $url;
    }

    static protected function booted()
    {
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }
}
