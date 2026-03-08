<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('video_file')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('category')->default('Tutoriál');
            $table->boolean('vip_only')->default(false);
            $table->string('duration', 20)->nullable();
            $table->string('author')->default('Admin');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};