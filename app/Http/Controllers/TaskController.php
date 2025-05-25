<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Events\TaskCreated;

class TaskController extends Controller
{
    /**
     * GET /api/tasks - Display a listing of all tasks
     */
    public function index()
    {
        return response()->json(Task::all());
    }

    /**
     * POST /api/tasks - Store a newly created task in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:new,in_progress,done'],
            'project_id' => ['required', 'exists:projects,id'],
            'author_id' => ['nullable', 'exists:users,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task = Task::create($validated);

        event(new TaskCreated($task));

        return response()->json($task, 201);
    }

    /**
     * GET /api/tasks/{id} - Display the specified task with its related project and assignee
     */
    public function show(string $id)
    {
        $task = Task::with(['project', 'assignee'])->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    /**
     * PUT /api/tasks/{id} - Update the specified task in storage
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'status' => ['sometimes', 'in:new,in_progress,done'],
            'project_id' => ['sometimes', 'exists:projects,id'],
            'author_id' => ['sometimes', 'required', 'exists:users,id'],
            'assigned_to' => ['sometimes', 'exists:users,id'],
            'due_date' => ['sometimes', 'date'],
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    /**
     * DELETE /api/tasks/{id} - Remove the specified task from storage
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
