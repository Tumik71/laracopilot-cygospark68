<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    protected $fillable = ['key', 'value'];

    private static array $defaults = [
        'primary_color'       => '#3B82F6',
        'secondary_color'     => '#1E40AF',
        'accent_color'        => '#F59E0B',
        'background_color'    => '#FFFFFF',
        'text_color'          => '#111827',
        'font_family'         => 'Inter',
        'font_size_base'      => '16',
        'header_style'        => 'default',
        'footer_style'        => 'default',
        'layout'              => 'wide',
        'border_radius'       => 'rounded',
        'site_name'           => 'Můj Portál',
        'site_tagline'        => 'Váš online domov',
        'hero_title'          => 'Vítejte na portálu',
        'hero_subtitle'       => 'Objevte naše možnosti a staňte se součástí komunity.',
        'hero_cta_text'       => 'Začít zdarma',
        'hero_cta_url'        => '/registrace',
        'show_hero'           => '1',
        'show_blog'           => '1',
        'show_gallery'        => '1',
        'show_testimonials'   => '1',
        'show_pricing'        => '1',
        'show_newsletter'     => '1',
        'custom_css'          => '',
        'logo_path'           => '',
        'favicon_path'        => '',
        'homepage_components' => '["hero","blog","gallery","testimonials","pricing","newsletter"]',
        'homepage_order'      => '["hero","blog","gallery","testimonials","pricing","newsletter"]',
    ];

    public static function getSetting(string $key, $default = null)
    {
        $setting = static::where('key', $key)->value('value');
        return $setting ?? ($default ?? static::$defaults[$key] ?? null);
    }

    public static function setSetting(string $key, $value)
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function setSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            static::setSetting($key, $value);
        }
    }

    public static function getSettings(): array
    {
        $db = static::all()->pluck('value', 'key')->toArray();
        return array_merge(static::$defaults, $db);
    }

    public static function getAllAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }

    public static function resetDefaults()
    {
        static::truncate();
    }
}