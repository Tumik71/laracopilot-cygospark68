<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vip_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->enum('type', ['video', 'tutorial', 'guide', 'download', 'webinar'])->default('video');
            $table->string('thumbnail')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('author')->default('Admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vip_contents');
    }
};