<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $videos = Video::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.video.index', compact('videos'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        return view('admin.video.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'nullable|url',
            'video_file' => 'nullable|mimetypes:video/mp4,video/avi,video/mov|max:512000',
            'thumbnail' => 'nullable|image|max:5120',
            'category' => 'required|string',
            'vip_only' => 'boolean',
            'duration' => 'nullable|string|max:20',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'category' => $request->category,
            'vip_only' => $request->has('vip_only'),
            'duration' => $request->duration,
            'author' => session('admin_user'),
        ];

        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('videos', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Video::create($data);
        return redirect()->route('admin.video.index')->with('success', 'Video bylo přidáno!');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $video = Video::findOrFail($id);
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'nullable|url',
            'category' => 'required|string',
            'duration' => 'nullable|string|max:20',
        ]);

        $video = Video::findOrFail($id);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'category' => $request->category,
            'vip_only' => $request->has('vip_only'),
            'duration' => $request->duration,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video->update($data);
        return redirect()->route('admin.video.index')->with('success', 'Video bylo aktualizováno!');
    }

    public function destroy($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        Video::findOrFail($id)->delete();
        return redirect()->route('admin.video.index')->with('success', 'Video bylo smazáno.');
    }
}