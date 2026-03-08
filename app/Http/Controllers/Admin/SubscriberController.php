<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(20);
        $totalRevenue = Subscriber::where('active', true)->count() * 299;
        return view('admin.subscribers.index', compact('subscribers', 'totalRevenue'));
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->update(['active' => false]);
        return redirect()->route('admin.subscribers.index')->with('success', 'Předplatné bylo zrušeno.');
    }
}