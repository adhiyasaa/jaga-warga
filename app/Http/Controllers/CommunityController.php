<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments.user', 'likes')
                    ->latest()
                    ->paginate(20);
        return view('community', compact('posts'));
    }

    public function storePost(Request $request)
    {
        // Validasi input
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // DEBUG: Pastikan kita pakai Model Post, bukan Report
        // Gunakan cara eksplisit agar tidak salah relasi
        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;
        $post->image_path = null; // Sesuai permintaan (null dulu)
        $post->video_path = null; // Sesuai permintaan (null dulu)
        $post->save();

        return back()->with('success', 'Post created successfully!');
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate(['content' => 'required|string|max:1000']);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added!');
    }

    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            return back()->with('success', 'Post unliked.');
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            return back()->with('success', 'Post liked!');
        }
    }

    public function destroyPost(Post $post)
    {
        if ($post->user_id !== Auth::id()) abort(403);
        $post->delete();
        return back()->with('success', 'Post deleted successfully!');
    }

    public function updatePost(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) abort(403);
        $request->validate(['content' => 'required|string|max:2000']);
        $post->update(['content' => $request->content]);
        return back()->with('success', 'Post updated successfully!');
    }
}