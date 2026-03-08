<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\GalleryItem;
use App\Models\Video;
use App\Models\VipContent;
use App\Models\Subscriber;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $stats = [
            'blog_posts' => BlogPost::count(),
            'published_posts' => BlogPost::where('published', true)->count(),
            'gallery_items' => GalleryItem::count(),
            'videos' => Video::count(),
            'vip_content' => VipContent::count(),
            'subscribers' => Subscriber::where('active', true)->count(),
            'monthly_revenue' => Subscriber::where('active', true)->count() * 299,
        ];

        $recentPosts = BlogPost::orderBy('created_at', 'desc')->take(5)->get();
        $recentSubscribers = Subscriber::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentSubscribers'));
    }
}