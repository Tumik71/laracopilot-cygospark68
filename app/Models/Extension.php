<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $fillable = ['key', 'active', 'settings'];

    protected $casts = ['active' => 'boolean'];

    public function getSetting(string $key, $default = null)
    {
        $settings = json_decode($this->settings ?? '{}', true);
        return $settings[$key] ?? $default;
    }
}