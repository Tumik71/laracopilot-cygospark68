<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->default('Obecné');
            $table->string('author')->default('Admin');
            $table->boolean('published')->default(false);
            $table->boolean('vip_only')->default(false);
            $table->unsignedInteger('views')->default(0);
            $table->string('meta_description', 160)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};