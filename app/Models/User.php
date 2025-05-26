<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    // function order_details()
    // {
    //     return $this->hasMany(OrderDetail::class);
    // }

    function payments()
    {
        return $this->hasMany(Payment::class);
    }

    function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }
}
