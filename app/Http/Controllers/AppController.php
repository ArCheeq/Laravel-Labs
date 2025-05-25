<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Return a list of all projects with their associated tasks.
     */
    public function index()
    {
        return response()->json(Project::with('tasks')->get());
    }

    /**
     * Create and store a new project in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'user_id' => Auth::id() ?? 1, // We don't have authorization, so currently set to 1 for testing
        ]);

        return response()->json($project, 201);
    }

    /**
     * Retrieve and return a specific project by its ID.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update an existing project by its ID.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Delete a specific project by its ID.
     */
    public function destroy(string $id)
    {
        //
    }
}
