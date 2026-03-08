<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\GalleryItem;
use App\Models\Video;
use App\Models\VipContent;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $latestPosts = BlogPost::where('published', true)->where('vip_only', false)
            ->orderBy('created_at', 'desc')->take(3)->get();
        $galleryItems = GalleryItem::where('vip_only', false)
            ->orderBy('created_at', 'desc')->take(6)->get();
        $latestVideos = Video::where('vip_only', false)
            ->orderBy('created_at', 'desc')->take(3)->get();
        return view('public.home', compact('latestPosts', 'galleryItems', 'latestVideos'));
    }

    public function blog()
    {
        $isVip = session('vip_logged_in');
        $posts = BlogPost::where('published', true)
            ->when(!$isVip, fn($q) => $q->where('vip_only', false))
            ->orderBy('created_at', 'desc')->paginate(9);
        return view('public.blog', compact('posts', 'isVip'));
    }

    public function blogPost($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('published', true)->firstOrFail();
        if ($post->vip_only && !session('vip_logged_in')) {
            return redirect()->route('vip.login')->with('warning', 'Tento článek je dostupný pouze pro VIP předplatitele.');
        }
        $post->increment('views');
        $related = BlogPost::where('category', $post->category)
            ->where('id', '!=', $post->id)->where('published', true)->take(3)->get();
        return view('public.blog-post', compact('post', 'related'));
    }

    public function gallery()
    {
        $isVip = session('vip_logged_in');
        $items = GalleryItem::when(!$isVip, fn($q) => $q->where('vip_only', false))
            ->orderBy('created_at', 'desc')->paginate(12);
        $categories = GalleryItem::select('category')->distinct()->pluck('category');
        return view('public.gallery', compact('items', 'categories', 'isVip'));
    }

    public function videoChat()
    {
        $isVip = session('vip_logged_in');
        $videos = Video::when(!$isVip, fn($q) => $q->where('vip_only', false))
            ->orderBy('created_at', 'desc')->paginate(9);
        return view('public.video-chat', compact('videos', 'isVip'));
    }

    public function vipInfo()
    {
        return view('public.vip-info');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10',
        ]);
        return back()->with('success', 'Děkujeme za zprávu! Odpovíme vám co nejdříve.');
    }
}