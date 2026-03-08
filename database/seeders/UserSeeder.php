<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'     => 'Test Uživatel',
            'email'    => 'uzivatel@portal.cz',
            'password' => Hash::make('Heslo1234!'),
            'role'     => 'user',
        ]);

        User::create([
            'name'     => 'VIP Člen',
            'email'    => 'vip@portal.cz',
            'password' => Hash::make('Vip1234!'),
            'role'     => 'vip',
        ]);

        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name'     => 'Uživatel ' . $i,
                'email'    => 'user'.$i.'@portal.cz',
                'password' => Hash::make('Heslo1234!'),
                'role'     => 'user',
            ]);
        }
    }
}