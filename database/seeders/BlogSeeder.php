<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Novinky', 'Návody', 'Tipy', 'Elektrotechnika', 'Projekty'];

        $posts = [
            ['Jak správně vybrat LED osvětlení', 'Průvodce výběrem LED osvětlení pro váš domov nebo firmu.'],
            ['Základy elektroinstalace', 'Vše co potřebujete vědět o domácí elektroinstalaci.'],
            ['Úspora energie v roce 2025', 'Praktické tipy jak snížit spotřebu elektrické energie.'],
            ['Solární panely – investice do budoucnosti', 'Přehled dostupných řešení pro fotovoltaiku.'],
            ['Inteligentní dům – Smart Home základy', 'Jak začít s automatizací domácnosti.'],
            ['Bezpečnost elektrických instalací', 'Nejčastější chyby a jak se jim vyhnout.'],
            ['Výběr správného jističe', 'Technický průvodce pro výběr jisticích prvků.'],
            ['Kabeláž strukturovaná vs. klasická', 'Porovnání typů kabelových rozvodů.'],
            ['Elektromobily a domácí nabíjení', 'Jak nainstalovat nabíjecí stanici doma.'],
            ['Rekuperace a větrání', 'Moderní řešení pro zdravý vzduch v interiéru.'],
        ];

        foreach ($posts as $index => $post) {
            BlogPost::create([
                'title'     => $post[0],
                'slug'      => Str::slug($post[0]) . '-' . ($index + 1),
                'content'   => '<p>' . $post[1] . '</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                'excerpt'   => $post[1],
                'category'  => $categories[array_rand($categories)],
                'published' => true,
            ]);
        }
    }
}