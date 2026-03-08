<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image', 'category', 'vip_only'
    ];

    protected $casts = [
        'vip_only' => 'boolean',
    ];
}