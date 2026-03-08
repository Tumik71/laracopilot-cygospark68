<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    private function authCheck()
    {
        return session('admin_logged_in');
    }

    public function index(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $query = GalleryItem::with('user');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.gallery.index', compact('items'));
    }

    public function pending()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $items = GalleryItem::with('user')->where('status', 'pending')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.gallery.pending', compact('items'));
    }

    public function create()
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|max:5120',
            'category'    => 'nullable|string|max:100',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        GalleryItem::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image_path'  => $path,
            'category'    => $request->category,
            'status'      => 'approved',
            'user_id'     => null,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Fotografie byla přidána.');
    }

    public function edit($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $item = GalleryItem::findOrFail($id);
        return view('admin.gallery.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $item = GalleryItem::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:5120',
            'category'    => 'nullable|string|max:100',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($item->image_path);
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Fotografie byla aktualizována.');
    }

    public function destroy($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $item = GalleryItem::findOrFail($id);
        Storage::disk('public')->delete($item->image_path);
        $item->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Fotografie byla smazána.');
    }

    public function approve($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        GalleryItem::findOrFail($id)->update(['status' => 'approved', 'approved_at' => now()]);
        return back()->with('success', 'Fotografie byla schválena.');
    }

    public function reject($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        GalleryItem::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Fotografie byla zamítnuta.');
    }
}