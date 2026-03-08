<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VipContent;
use Illuminate\Http\Request;

class VipController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $contents = VipContent::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.vip.index', compact('contents'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        return view('admin.vip.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:video,tutorial,guide,download,webinar',
            'thumbnail' => 'nullable|image|max:5120',
            'file' => 'nullable|file|max:51200',
            'youtube_url' => 'nullable|url',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'youtube_url' => $request->youtube_url,
            'author' => session('admin_user'),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('vip/thumbnails', 'public');
        }
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('vip/files', 'public');
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }

        VipContent::create($data);
        return redirect()->route('admin.vip.index')->with('success', 'VIP obsah byl přidán!');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $content = VipContent::findOrFail($id);
        return view('admin.vip.edit', compact('content'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:video,tutorial,guide,download,webinar',
            'youtube_url' => 'nullable|url',
        ]);

        $vip = VipContent::findOrFail($id);
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'youtube_url' => $request->youtube_url,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('vip/thumbnails', 'public');
        }

        $vip->update($data);
        return redirect()->route('admin.vip.index')->with('success', 'VIP obsah byl aktualizován!');
    }

    public function destroy($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        VipContent::findOrFail($id)->delete();
        return redirect()->route('admin.vip.index')->with('success', 'VIP obsah byl smazán.');
    }
}