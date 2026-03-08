<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    private function authCheck()
    {
        return session('admin_logged_in');
    }

    public function index(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $query = BlogPost::query();
        if ($request->search) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
        if ($request->status) {
            $query->where('published', $request->status === 'published');
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'excerpt'    => 'nullable|string|max:500',
            'image'      => 'nullable|image|max:5120',
            'category'   => 'nullable|string|max:100',
        ]);

        $data = [
            'title'     => $request->title,
            'slug'      => Str::slug($request->title) . '-' . time(),
            'content'   => $request->content,
            'excerpt'   => $request->excerpt,
            'category'  => $request->category,
            'published' => $request->has('published'),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('blog', 'public');
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Článek byl vytvořen.');
    }

    public function edit($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $post = BlogPost::findOrFail($id);
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $post = BlogPost::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image'   => 'nullable|image|max:5120',
            'category'=> 'nullable|string|max:100',
        ]);

        $data = [
            'title'     => $request->title,
            'content'   => $request->content,
            'excerpt'   => $request->excerpt,
            'category'  => $request->category,
            'published' => $request->has('published'),
        ];

        if ($request->hasFile('image')) {
            if ($post->image_path) Storage::disk('public')->delete($post->image_path);
            $data['image_path'] = $request->file('image')->store('blog', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Článek byl aktualizován.');
    }

    public function destroy($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $post = BlogPost::findOrFail($id);
        if ($post->image_path) Storage::disk('public')->delete($post->image_path);
        $post->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Článek byl smazán.');
    }
}