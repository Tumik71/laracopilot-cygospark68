<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'phone',
        'active', 'plan', 'subscribed_at',
        'stripe_customer_id', 'stripe_session_id'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'active' => 'boolean',
        'subscribed_at' => 'datetime',
    ];
}