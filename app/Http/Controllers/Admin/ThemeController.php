<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    private function authCheck()
    {
        return session('admin_logged_in');
    }

    public function index()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $theme = ThemeSetting::getSettings();
        return view('admin.theme.index', compact('theme'));
    }

    public function update(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $settings = [
            'primary_color'     => $request->primary_color ?? '#3B82F6',
            'secondary_color'   => $request->secondary_color ?? '#1E40AF',
            'accent_color'      => $request->accent_color ?? '#F59E0B',
            'background_color'  => $request->background_color ?? '#FFFFFF',
            'text_color'        => $request->text_color ?? '#111827',
            'font_family'       => $request->font_family ?? 'Inter',
            'font_size_base'    => $request->font_size_base ?? '16',
            'header_style'      => $request->header_style ?? 'default',
            'footer_style'      => $request->footer_style ?? 'default',
            'layout'            => $request->layout ?? 'wide',
            'border_radius'     => $request->border_radius ?? 'rounded',
            'site_name'         => $request->site_name ?? 'Můj Portál',
            'site_tagline'      => $request->site_tagline ?? '',
            'hero_title'        => $request->hero_title ?? '',
            'hero_subtitle'     => $request->hero_subtitle ?? '',
            'hero_cta_text'     => $request->hero_cta_text ?? 'Začít',
            'hero_cta_url'      => $request->hero_cta_url ?? '/',
            'show_hero'         => $request->has('show_hero') ? '1' : '0',
            'show_blog'         => $request->has('show_blog') ? '1' : '0',
            'show_gallery'      => $request->has('show_gallery') ? '1' : '0',
            'show_testimonials' => $request->has('show_testimonials') ? '1' : '0',
            'show_pricing'      => $request->has('show_pricing') ? '1' : '0',
            'show_newsletter'   => $request->has('show_newsletter') ? '1' : '0',
            'custom_css'        => $request->custom_css ?? '',
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('theme', 'public');
            $settings['logo_path'] = $path;
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('theme', 'public');
            $settings['favicon_path'] = $path;
        }

        ThemeSetting::setSettings($settings);

        return back()->with('success', 'Vzhled byl uložen.');
    }

    public function reset()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        ThemeSetting::resetDefaults();
        return back()->with('success', 'Vzhled byl resetován na výchozí nastavení.');
    }

    public function updateComponents(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $components = $request->components ?? [];
        ThemeSetting::setSetting('homepage_components', json_encode($components));
        ThemeSetting::setSetting('homepage_order', json_encode($request->order ?? []));

        return back()->with('success', 'Rozložení komponent bylo uloženo.');
    }

    public function export()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $settings = ThemeSetting::getAllAsArray();
        $json     = json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return response($json, 200, [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => 'attachment; filename="theme-export-'.date('Y-m-d').'.json"',
        ]);
    }

    public function import(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $request->validate(['file' => 'required|file|mimes:json']);

        $content  = file_get_contents($request->file('file')->getRealPath());
        $settings = json_decode($content, true);

        if (!$settings) {
            return back()->withErrors(['file' => 'Neplatný JSON soubor.']);
        }

        ThemeSetting::setSettings($settings);

        return back()->with('success', 'Téma bylo importováno.');
    }
}