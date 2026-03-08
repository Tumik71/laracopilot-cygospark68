<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $items = GalleryItem::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'image' => 'required|image|max:10240',
            'vip_only' => 'boolean',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        GalleryItem::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $path,
            'vip_only' => $request->has('vip_only'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Fotografie byla přidána do galerie!');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        $item = GalleryItem::findOrFail($id);
        return view('admin.gallery.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:10240',
        ]);

        $item = GalleryItem::findOrFail($id);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'vip_only' => $request->has('vip_only'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $item->update($data);
        return redirect()->route('admin.gallery.index')->with('success', 'Fotografie byla aktualizována!');
    }

    public function destroy($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        GalleryItem::findOrFail($id)->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Fotografie byla smazána.');
    }
}