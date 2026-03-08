<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email');
            $table->boolean('two_factor_enabled')->default(false)->after('role');
            $table->integer('two_factor_code')->nullable()->after('two_factor_enabled');
            $table->timestamp('two_factor_expires_at')->nullable()->after('two_factor_code');
            $table->timestamp('banned_at')->nullable()->after('two_factor_expires_at');
            $table->timestamp('last_login_at')->nullable()->after('banned_at');
            $table->string('avatar')->nullable()->after('last_login_at');
            $table->text('bio')->nullable()->after('avatar');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','two_factor_enabled','two_factor_code','two_factor_expires_at','banned_at','last_login_at','avatar','bio']);
        });
    }
};