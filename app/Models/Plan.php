<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'slug', 'price', 'interval', 'description', 'features', 'active', 'stripe_price_id',
    ];

    protected $casts = [
        'price'  => 'decimal:2',
        'active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getFeaturesListAttribute(): array
    {
        return array_filter(array_map('trim', explode('\n', $this->features ?? '')));
    }
}