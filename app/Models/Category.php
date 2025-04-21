<?php

namespace App\Models;

use App\Traits\Trans;
use Illuminate\Database\Eloquent\Model;

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

}
