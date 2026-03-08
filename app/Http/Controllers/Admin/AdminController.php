<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GalleryItem;
use App\Models\BlogPost;
use App\Models\Subscription;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) {
            return false;
        }
        return true;
    }

    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admins = [
            'admin@portal.cz'     => ['heslo' => 'Admin2024!',    'jmeno' => 'Administrátor', 'role' => 'superadmin'],
            'redaktor@portal.cz'  => ['heslo' => 'Redaktor2024!', 'jmeno' => 'Redaktor',      'role' => 'editor'],
        ];

        if (isset($admins[$request->email]) && $admins[$request->email]['heslo'] === $request->password) {
            $admin = $admins[$request->email];
            session([
                'admin_logged_in' => true,
                'admin_name'      => $admin['jmeno'],
                'admin_email'     => $request->email,
                'admin_role'      => $admin['role'],
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Nesprávné přihlašovací údaje.']);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_name', 'admin_email', 'admin_role']);
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $stats = [
            'users'            => User::count(),
            'users_today'      => User::whereDate('created_at', today())->count(),
            'active_subs'      => Subscription::where('status', 'active')->count(),
            'revenue_month'    => Subscription::where('status', 'active')->whereMonth('created_at', now()->month)->sum('amount'),
            'gallery_pending'  => GalleryItem::where('status', 'pending')->count(),
            'gallery_total'    => GalleryItem::count(),
            'blog_posts'       => BlogPost::count(),
            'comments_pending' => Comment::where('approved', false)->count(),
        ];

        $recentUsers    = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentGallery  = GalleryItem::where('status', 'pending')->orderBy('created_at', 'desc')->take(5)->get();
        $recentComments = Comment::where('approved', false)->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentGallery', 'recentComments'));
    }
}