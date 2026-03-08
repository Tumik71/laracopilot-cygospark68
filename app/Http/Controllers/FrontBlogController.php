<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;

class FrontBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::where('published', true);

        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->search) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $posts      = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = BlogPost::where('published', true)->distinct()->pluck('category')->filter();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('published', true)->firstOrFail();

        $comments = Comment::where('commentable_type', BlogPost::class)
                           ->where('commentable_id', $post->id)
                           ->where('approved', true)
                           ->with('user')
                           ->orderBy('created_at', 'asc')
                           ->get();

        $related = BlogPost::where('published', true)
                           ->where('id', '!=', $post->id)
                           ->where('category', $post->category)
                           ->take(3)
                           ->get();

        return view('blog.show', compact('post', 'comments', 'related'));
    }

    public function comment(Request $request, $id)
    {
        if (!session('user_id')) {
            return back()->withErrors(['Musíte být přihlášeni pro komentování.']);
        }

        $request->validate(['content' => 'required|string|max:1000']);

        BlogPost::where('published', true)->findOrFail($id);

        Comment::create([
            'user_id'          => session('user_id'),
            'commentable_type' => BlogPost::class,
            'commentable_id'   => $id,
            'content'          => $request->content,
            'approved'         => false,
        ]);

        return back()->with('success', 'Komentář byl odeslán ke schválení.');
    }
}