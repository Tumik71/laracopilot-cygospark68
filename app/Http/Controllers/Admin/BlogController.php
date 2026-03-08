<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'published' => 'boolean',
            'vip_only' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
        ]);

        $validated['slug'] = Str::slug($request->title) . '-' . time();
        $validated['author'] = session('admin_user');
        $validated['published'] = $request->has('published');
        $validated['vip_only'] = $request->has('vip_only');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog', 'public');
            $validated['image'] = $path;
        }

        BlogPost::create($validated);
        return redirect()->route('admin.blog.index')->with('success', 'Článek byl úspěšně vytvořen!');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $post = BlogPost::findOrFail($id);
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'meta_description' => 'nullable|string|max:160',
        ]);

        $post = BlogPost::findOrFail($id);
        $validated['published'] = $request->has('published');
        $validated['vip_only'] = $request->has('vip_only');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog', 'public');
            $validated['image'] = $path;
        }

        $post->update($validated);
        return redirect()->route('admin.blog.index')->with('success', 'Článek byl úspěšně aktualizován!');
    }

    public function destroy($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        BlogPost::findOrFail($id)->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Článek byl smazán.');
    }
}