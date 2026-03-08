<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VipContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'type', 'thumbnail',
        'youtube_url', 'file_path', 'file_name', 'author'
    ];

    protected $casts = [];

    public function getTypeLabel()
    {
        return match($this->type) {
            'video' => '🎬 Video',
            'tutorial' => '📚 Tutoriál',
            'guide' => '📋 Průvodce',
            'download' => '⬇️ Ke stažení',
            'webinar' => '🎥 Webinář',
            default => $this->type,
        };
    }
}