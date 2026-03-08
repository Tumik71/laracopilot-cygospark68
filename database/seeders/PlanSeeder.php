<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create([
            'name'        => 'Základní',
            'slug'        => 'basic',
            'price'       => 99.00,
            'interval'    => 'monthly',
            'description' => 'Ideální pro začátečníky.',
            'features'    => "Přístup ke galerii\nBlog\nZákladní podpora",
            'active'      => true,
        ]);

        Plan::create([
            'name'        => 'VIP',
            'slug'        => 'vip',
            'price'       => 299.00,
            'interval'    => 'monthly',
            'description' => 'Plný přístup ke všemu obsahu.',
            'features'    => "Vše ze Základního\nVIP obsah\nPrioritní podpora\nStahování fotografií",
            'active'      => true,
        ]);

        Plan::create([
            'name'        => 'VIP Roční',
            'slug'        => 'vip-yearly',
            'price'       => 2490.00,
            'interval'    => 'yearly',
            'description' => 'Nejlepší hodnota – ušetřete 30%.',
            'features'    => "Vše z VIP\nRoční úspora 30%\nExkluzivní obsah\nPersonální konzultace",
            'active'      => true,
        ]);
    }
}