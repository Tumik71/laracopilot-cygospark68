<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\VipContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StripeController extends Controller
{
    private string $monthlyPrice = '299';
    private string $currency = 'czk';

    public function showLogin()
    {
        if (session('vip_logged_in')) return redirect()->route('vip.content');
        return view('vip.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $subscriber = Subscriber::where('email', $request->email)
            ->where('active', true)->first();

        if ($subscriber && Hash::check($request->password, $subscriber->password)) {
            session([
                'vip_logged_in' => true,
                'vip_user' => $subscriber->name,
                'vip_email' => $subscriber->email,
                'vip_id' => $subscriber->id,
            ]);
            return redirect()->route('vip.content')->with('success', 'Vítejte ve VIP sekci!');
        }

        return back()->withErrors(['email' => 'Nesprávné přihlašovací údaje nebo předplatné není aktivní.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['vip_logged_in', 'vip_user', 'vip_email', 'vip_id']);
        return redirect()->route('home')->with('success', 'Byli jste odhlášeni.');
    }

    public function showRegister()
    {
        if (session('vip_logged_in')) return redirect()->route('vip.content');
        return view('vip.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subscribers,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $subscriber = Subscriber::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'active' => false,
            'plan' => 'monthly',
        ]);

        session(['pending_subscriber_id' => $subscriber->id]);
        return redirect()->route('vip.subscribe');
    }

    public function subscribe()
    {
        if (!session('pending_subscriber_id') && !session('vip_id')) {
            return redirect()->route('vip.register');
        }
        return view('vip.subscribe', [
            'price' => $this->monthlyPrice,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    public function checkout(Request $request)
    {
        // Stripe Checkout Session
        $stripeSecret = config('services.stripe.secret');
        
        if (!$stripeSecret) {
            return redirect()->route('vip.success')->with('info', 'Testovací režim - předplatné aktivováno.');
        }

        try {
            \Stripe\Stripe::setApiKey($stripeSecret);
            
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $this->currency,
                        'product_data' => ['name' => 'VIP Předplatné - Elektro Portal'],
                        'unit_amount' => (int)$this->monthlyPrice * 100,
                        'recurring' => ['interval' => 'month'],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => route('vip.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('vip.cancel'),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Chyba při přesměrování na platbu: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $subscriberId = session('pending_subscriber_id');
        if ($subscriberId) {
            $subscriber = Subscriber::find($subscriberId);
            if ($subscriber) {
                $subscriber->update([
                    'active' => true,
                    'subscribed_at' => now(),
                    'stripe_session_id' => $request->session_id ?? 'manual',
                ]);
                session()->forget('pending_subscriber_id');
                session([
                    'vip_logged_in' => true,
                    'vip_user' => $subscriber->name,
                    'vip_email' => $subscriber->email,
                    'vip_id' => $subscriber->id,
                ]);
            }
        }
        return view('vip.success');
    }

    public function cancel()
    {
        return view('vip.cancel');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
            
            if ($event->type === 'customer.subscription.deleted') {
                $email = $event->data->object->customer_email ?? null;
                if ($email) {
                    Subscriber::where('email', $email)->update(['active' => false]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['status' => 'ok']);
    }

    public function vipContent()
    {
        if (!session('vip_logged_in')) {
            return redirect()->route('vip.login')->with('warning', 'Přihlaste se pro přístup do VIP sekce.');
        }
        $contents = VipContent::orderBy('created_at', 'desc')->paginate(12);
        return view('vip.content', compact('contents'));
    }

    public function vipVideo($id)
    {
        if (!session('vip_logged_in')) {
            return redirect()->route('vip.login');
        }
        $video = VipContent::findOrFail($id);
        return view('vip.video', compact('video'));
    }
}