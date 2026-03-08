<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;

class FrontGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryItem::where('status', 'approved');

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $items      = $query->withAvg('ratings', 'value')->orderBy('created_at', 'desc')->paginate(12);
        $categories = GalleryItem::where('status', 'approved')->distinct()->pluck('category')->filter();

        return view('gallery.index', compact('items', 'categories'));
    }

    public function show($id)
    {
        $item     = GalleryItem::where('status', 'approved')->withAvg('ratings', 'value')->findOrFail($id);
        $comments = Comment::where('commentable_type', GalleryItem::class)
                           ->where('commentable_id', $id)
                           ->where('approved', true)
                           ->with('user')
                           ->orderBy('created_at', 'desc')
                           ->get();

        $userRating = null;
        if (session('user_id')) {
            $userRating = Rating::where('rateable_type', GalleryItem::class)
                               ->where('rateable_id', $id)
                               ->where('user_id', session('user_id'))
                               ->value('value');
        }

        return view('gallery.show', compact('item', 'comments', 'userRating'));
    }

    public function rate(Request $request, $id)
    {
        if (!session('user_id')) {
            return back()->withErrors(['Musíte být přihlášeni pro hodnocení.']);
        }

        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        GalleryItem::where('status', 'approved')->findOrFail($id);

        Rating::updateOrCreate(
            [
                'rateable_type' => GalleryItem::class,
                'rateable_id'   => $id,
                'user_id'       => session('user_id'),
            ],
            ['value' => $request->rating]
        );

        return back()->with('success', 'Hodnocení bylo uloženo.');
    }

    public function comment(Request $request, $id)
    {
        if (!session('user_id')) {
            return back()->withErrors(['Musíte být přihlášeni pro komentování.']);
        }

        $request->validate(['content' => 'required|string|max:1000']);

        GalleryItem::where('status', 'approved')->findOrFail($id);

        Comment::create([
            'user_id'          => session('user_id'),
            'commentable_type' => GalleryItem::class,
            'commentable_id'   => $id,
            'content'          => $request->content,
            'approved'         => false,
        ]);

        return back()->with('success', 'Komentář byl odeslán ke schválení.');
    }
}