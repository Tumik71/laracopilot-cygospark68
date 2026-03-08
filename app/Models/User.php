<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'two_factor_enabled', 'two_factor_code', 'two_factor_expires_at',
        'banned_at', 'last_login_at', 'avatar', 'bio',
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_code'];

    protected $casts = [
        'two_factor_enabled'    => 'boolean',
        'two_factor_expires_at' => 'datetime',
        'banned_at'             => 'datetime',
        'last_login_at'         => 'datetime',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latestOfMany();
    }

    public function galleryItems()
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function isVip(): bool
    {
        return in_array($this->role, ['vip', 'admin', 'superadmin']) ||
               ($this->activeSubscription !== null);
    }

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }
}