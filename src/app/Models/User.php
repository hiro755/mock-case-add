<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Like;
use App\Models\Product;
use App\Models\Purchase;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function exhibited_items()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function purchased_items()
    {
        return $this->hasMany(Purchase::class);
    }

    public function soldProducts()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function boughtProducts()
    {
        return $this->hasMany(Product::class, 'buyer_id');
    }

    public function getAverageRatingAttribute()
    {
        $ratings = collect();

        $ratings = $ratings->merge(
            $this->soldProducts()->whereNotNull('rating_from_buyer')->pluck('rating_from_buyer')
        );

        $ratings = $ratings->merge(
            $this->boughtProducts()->whereNotNull('rating_from_seller')->pluck('rating_from_seller')
        );

        if ($ratings->isEmpty()) {
            return null;
        }

        return round($ratings->avg());
    }
}