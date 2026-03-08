<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'youtube_url', 'video_file',
        'thumbnail', 'category', 'vip_only', 'duration', 'author', 'views'
    ];

    protected $casts = [
        'vip_only' => 'boolean',
        'views' => 'integer',
    ];

    public function getYoutubeIdAttribute()
    {
        if (!$this->youtube_url) return null;
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $matches);
        return $matches[1] ?? null;
    }
}