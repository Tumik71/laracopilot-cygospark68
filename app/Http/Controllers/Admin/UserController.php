<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function authCheck()
    {
        return session('admin_logged_in');
    }

    public function index(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $query = User::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->status === 'banned') {
            $query->whereNotNull('banned_at');
        } elseif ($request->status === 'active') {
            $query->whereNull('banned_at');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $user          = User::findOrFail($id);
        $subscriptions = Subscription::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        $galleryItems  = \App\Models\GalleryItem::where('user_id', $id)->orderBy('created_at', 'desc')->take(10)->get();
        $comments      = \App\Models\Comment::where('user_id', $id)->orderBy('created_at', 'desc')->take(10)->get();

        return view('admin.users.show', compact('user', 'subscriptions', 'galleryItems', 'comments'));
    }

    public function edit($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$id,
            'role'     => 'required|in:user,vip,editor,admin',
            'password' => 'nullable|min:8',
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $id)->with('success', 'Uživatel byl aktualizován.');
    }

    public function destroy($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Uživatel byl smazán.');
    }

    public function ban($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        User::findOrFail($id)->update(['banned_at' => now()]);
        return back()->with('success', 'Uživatel byl zablokován.');
    }

    public function unban($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        User::findOrFail($id)->update(['banned_at' => null]);
        return back()->with('success', 'Uživatel byl odblokován.');
    }
}