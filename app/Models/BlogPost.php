<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'image',
        'category', 'author', 'published', 'vip_only',
        'views', 'meta_description'
    ];

    protected $casts = [
        'published' => 'boolean',
        'vip_only' => 'boolean',
        'views' => 'integer',
    ];

    public function getExcerptAttribute($value)
    {
        return $value ?: \Illuminate\Support\Str::limit(strip_tags($this->content), 150);
    }
}