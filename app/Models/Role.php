<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    protected $guarded = [];

    function users()
    {
        return $this->hasMany(User::class);
    }

    function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
