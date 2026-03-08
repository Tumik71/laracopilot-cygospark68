<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_items', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('category');
            }
            if (!Schema::hasColumn('gallery_items', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('status');
            }
            if (!Schema::hasColumn('gallery_items', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_at']);
        });
    }
};