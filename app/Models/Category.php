<?php

namespace App\Models;

use App\Traits\Trans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use Trans;

    protected $guarded = [];

    protected $appends = ['image_path'];


    function products()
    {
        return $this->hasMany(Product::class);
    }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getImagePathAttribute()
    {
        $url = asset('assets/img/100x80.svg');
        if($this->image){
            $url = asset('storage/'.$this->image->path);
        }
        return $url;
    }

    protected static function booted()
    {
        static::creating(function(Category $category){
            $category->slug = Str::slug($category->name);
        });

        static::updating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });
    }

}
