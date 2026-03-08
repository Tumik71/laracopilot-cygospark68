<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    private function authCheck()
    {
        return session('admin_logged_in');
    }

    private function getAvailableExtensions()
    {
        return [
            'google_analytics' => [
                'name'        => 'Google Analytics',
                'description' => 'Sledování návštěvnosti webu pomocí Google Analytics 4.',
                'icon'        => '📊',
                'version'     => '1.0.0',
                'settings'    => ['tracking_id'],
            ],
            'recaptcha' => [
                'name'        => 'Google reCAPTCHA',
                'description' => 'Ochrana formulářů před spamem a boty.',
                'icon'        => '🛡️',
                'version'     => '1.0.0',
                'settings'    => ['site_key', 'secret_key'],
            ],
            'live_chat' => [
                'name'        => 'Live Chat',
                'description' => 'Přidejte live chat podporu na váš web (Tawk.to).',
                'icon'        => '💬',
                'version'     => '1.0.0',
                'settings'    => ['property_id'],
            ],
            'cookie_consent' => [
                'name'        => 'Cookie Souhlas',
                'description' => 'GDPR-kompatibilní banner pro souhlas s cookies.',
                'icon'        => '🍪',
                'version'     => '1.0.0',
                'settings'    => ['message', 'button_text'],
            ],
            'social_login' => [
                'name'        => 'Přihlášení přes sociální sítě',
                'description' => 'Umožní uživatelům přihlásit se přes Google a Facebook.',
                'icon'        => '🔗',
                'version'     => '1.0.0',
                'settings'    => ['google_client_id', 'facebook_app_id'],
            ],
            'newsletter' => [
                'name'        => 'Newsletter',
                'description' => 'Integrace s Mailchimp pro správu odběratelů.',
                'icon'        => '📧',
                'version'     => '1.0.0',
                'settings'    => ['api_key', 'list_id'],
            ],
            'seo_tools' => [
                'name'        => 'SEO nástroje',
                'description' => 'Správa meta tagů, sitemap a robots.txt.',
                'icon'        => '🔍',
                'version'     => '1.0.0',
                'settings'    => ['default_description', 'keywords'],
            ],
            'watermark' => [
                'name'        => 'Vodoznak na fotografie',
                'description' => 'Automaticky přidá vodoznak na nahrané fotografie.',
                'icon'        => '🖼️',
                'version'     => '1.0.0',
                'settings'    => ['text', 'opacity', 'position'],
            ],
        ];
    }

    public function index()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $available  = $this->getAvailableExtensions();
        $installed  = Extension::all()->keyBy('key');

        return view('admin.extensions.index', compact('available', 'installed'));
    }

    public function activate($key)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        Extension::updateOrCreate(
            ['key' => $key],
            ['active' => true, 'settings' => '{}']
        );

        return back()->with('success', 'Rozšíření bylo aktivováno.');
    }

    public function deactivate($key)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        Extension::where('key', $key)->update(['active' => false]);
        return back()->with('success', 'Rozšíření bylo deaktivováno.');
    }

    public function settings($key)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $available  = $this->getAvailableExtensions();
        $extension  = Extension::where('key', $key)->first();
        $definition = $available[$key] ?? null;

        if (!$definition) {
            return redirect()->route('admin.extensions.index')->withErrors(['Rozšíření nenalezeno.']);
        }

        return view('admin.extensions.settings', compact('key', 'extension', 'definition'));
    }

    public function saveSettings(Request $request, $key)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        Extension::where('key', $key)->update([
            'settings' => json_encode($request->except('_token')),
        ]);

        return back()->with('success', 'Nastavení bylo uloženo.');
    }
}