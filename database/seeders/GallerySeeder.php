<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryItem;

class GallerySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Krajina', 'Portrét', 'Architektura', 'Příroda', 'Abstraktní'];
        $statuses   = ['approved', 'approved', 'approved', 'pending', 'rejected'];

        for ($i = 1; $i <= 25; $i++) {
            GalleryItem::create([
                'title'       => 'Fotografie ' . $i,
                'description' => 'Popis fotografie číslo ' . $i . '. Krásný záběr z přírody.',
                'image_path'  => 'gallery/placeholder-' . ($i % 5 + 1) . '.jpg',
                'category'    => $categories[array_rand($categories)],
                'status'      => $statuses[array_rand($statuses)],
                'user_id'     => rand(1, 5),
            ]);
        }
    }
}