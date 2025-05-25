<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * GET /api/comments - Display a list of comments with their related tasks
     */
    public function index()
    {
        return Comment::with('task')->get();
    }

    /**
     * POST /api/comments - Store a new comment in the database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'user_id' => ['required', 'exists:users,id'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $comment = Comment::create($validated);

        return response()->json($comment, 201);
    }

    /**
     * GET /api/comments/{id} - Display a specific comment by ID with its related task
     */
    public function show(string $id)
    {
        $comment = Comment::with('task')->find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return response()->json($comment);
    }

    /**
     * PUT /api/comments/{id} - Update the specified comment in the database
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $validated = $request->validate([
            'task_id' => ['sometimes', 'exists:tasks,id'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'content' => ['sometimes', 'string', 'max:1000'],
        ]);

        $comment->update($validated);

        return response()->json($comment);
    }

    /**
     * DELETE /api/comments/{id} - Delete the specified comment from the database
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
