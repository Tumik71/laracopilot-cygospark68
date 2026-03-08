<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private function authCheck()
    {
        return session('admin_logged_in');
    }

    public function index(Request $request)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');

        $query = Comment::with('user');

        if ($request->status === 'pending') {
            $query->where('approved', false);
        } elseif ($request->status === 'approved') {
            $query->where('approved', true);
        }

        if ($request->search) {
            $query->where('content', 'like', '%'.$request->search.'%');
        }

        $comments = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function approve($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        Comment::findOrFail($id)->update(['approved' => true]);
        return back()->with('success', 'Komentář byl schválen.');
    }

    public function destroy($id)
    {
        if (!$this->authCheck()) return redirect()->route('admin.login');
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Komentář byl smazán.');
    }
}