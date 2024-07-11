<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);
        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);
        return redirect()->route('home')->with('success', 'Comment added successfully.');
    }

    public function edit(Comment $comment)
    {
        Gate::authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);
        $request->validate([
            'body' => 'sometimes|string',
        ]);
        $comment->update($request->only('body'));
        return redirect()->route('home')->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);
        $comment->delete();
        return redirect()->route('home')->with('success', 'Comment deleted successfully.');
    }
}

