<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\BlogPost;
use App\Models\GalleryItem;
use App\Models\Video;
use App\Models\VipContent;
use App\Models\Subscriber;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Blog posty
        $blogPosts = [
            ['title' => 'Jak správně provést elektroinstalaci v rodinném domě', 'category' => 'Instalace', 'published' => true, 'vip_only' => false],
            ['title' => 'Bezpečnost při práci s elektřinou – základní pravidla', 'category' => 'Bezpečnost', 'published' => true, 'vip_only' => false],
            ['title' => 'Moderní LED osvětlení – průvodce výběrem', 'category' => 'Osvětlení', 'published' => true, 'vip_only' => false],
            ['title' => 'Revize elektroinstalace – co vše zahrnuje?', 'category' => 'Revize', 'published' => true, 'vip_only' => false],
            ['title' => 'Fotovoltaika – jak funguje a co potřebujete vědět', 'category' => 'Obnovitelné zdroje', 'published' => true, 'vip_only' => false],
            ['title' => 'Zásuvkové okruhy – normy a správné zapojení', 'category' => 'Instalace', 'published' => true, 'vip_only' => false],
            ['title' => 'Chytrá domácnost – elektroinstalace pro smart home', 'category' => 'Smart Home', 'published' => true, 'vip_only' => false],
            ['title' => 'VIP: Profesionální schémata zapojení rozvaděčů', 'category' => 'Rozvaděče', 'published' => true, 'vip_only' => true],
            ['title' => 'VIP: Projektová dokumentace elektroinstalací krok za krokem', 'category' => 'Projektování', 'published' => true, 'vip_only' => true],
            ['title' => 'Výběr správného jističe – průvodce pro elektrikáře', 'category' => 'Komponenty', 'published' => true, 'vip_only' => false],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']) . '-' . rand(1000, 9999),
                'content' => '<p>Tento článek poskytuje detailní informace o tématu ' . $post['title'] . '. Elektroinstalace vyžaduje odborné znalosti a dodržování bezpečnostních předpisů ČSN. Vždy pracujte v souladu s platnými normami a předpisy.</p><p>Správná elektroinstalace je základem bezpečného bydlení. Dodržujte vždy platné normy ČSN EN 33 2000 a pracujte s certifikovanými materiály od ověřených dodavatelů.</p><p>Pokud si nejste jisti, vždy se obraťte na certifikovaného elektrikáře. Bezpečnost je na prvním místě!</p>',
                'excerpt' => 'Přečtěte si náš podrobný průvodce k tématu: ' . $post['title'],
                'category' => $post['category'],
                'author' => 'Admin',
                'published' => $post['published'],
                'vip_only' => $post['vip_only'],
                'views' => rand(50, 2500),
                'meta_description' => 'Elektro Portal - ' . $post['title'],
            ]);
        }

        // Galerie
        $galleryCategories = ['Instalace', 'Rozvaděče', 'Osvětlení', 'Revize', 'Fotovoltaika'];
        for ($i = 1; $i <= 15; $i++) {
            GalleryItem::create([
                'title' => 'Elektroinstalace – projekt č. ' . $i,
                'description' => 'Realizace elektroinstalace v objektu. Použité materiály splňují normy ČSN.',
                'image' => 'gallery/placeholder-' . $i . '.jpg',
                'category' => $galleryCategories[array_rand($galleryCategories)],
                'vip_only' => $i > 10,
            ]);
        }

        // Videa
        $videos = [
            ['title' => 'Zapojení zásuvky – krok za krokem', 'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'category' => 'Základy', 'vip_only' => false, 'duration' => '12:34'],
            ['title' => 'Jak číst elektroschéma', 'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'category' => 'Vzdělávání', 'vip_only' => false, 'duration' => '18:45'],
            ['title' => 'Instalace LED pásku', 'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'category' => 'Osvětlení', 'vip_only' => false, 'duration' => '8:20'],
            ['title' => 'VIP: Zapojení třífázového rozvaděče', 'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'category' => 'Rozvaděče', 'vip_only' => true, 'duration' => '45:00'],
            ['title' => 'VIP: Fotovoltaika – instalace kompletního systému', 'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'category' => 'FVE', 'vip_only' => true, 'duration' => '62:15'],
            ['title' => 'Bezpečnostní předpisy v elektrotechnice', 'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'category' => 'Bezpečnost', 'vip_only' => false, 'duration' => '22:10'],
        ];

        foreach ($videos as $video) {
            Video::create(array_merge($video, ['author' => 'Admin', 'views' => rand(100, 5000)]));
        }

        // VIP obsah
        $vipContents = [
            ['title' => 'Kompletní průvodce projektem elektroinstalace', 'type' => 'guide'],
            ['title' => 'Šablony pro revizní zprávy', 'type' => 'download'],
            ['title' => 'Webinář: Moderní elektroinstalace 2024', 'type' => 'webinar'],
            ['title' => 'Tutoriál: Zapojení fotovoltaické elektrárny', 'type' => 'tutorial'],
            ['title' => 'Video: Profesionální práce s měřicími přístroji', 'type' => 'video'],
        ];

        foreach ($vipContents as $vip) {
            VipContent::create([
                'title' => $vip['title'],
                'content' => '<p>Exkluzivní VIP obsah dostupný pouze pro předplatitele Elektro Portálu. Tento materiál obsahuje profesionální postupy a know-how z praxe certifikovaných elektrikářů.</p>',
                'type' => $vip['type'],
                'author' => 'Admin',
            ]);
        }

        // Testovací VIP předplatitel
        Subscriber::create([
            'name' => 'Jan Novák',
            'email' => 'vip@elektro-portal.cz',
            'password' => Hash::make('VipHeslo2024!'),
            'phone' => '+420 777 123 456',
            'active' => true,
            'plan' => 'monthly',
            'subscribed_at' => now(),
        ]);
    }
}