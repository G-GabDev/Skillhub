<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // 🔓 Anyone can view open projects
    public function index()
    {
        $projects = Project::with('user')
            ->where('status', 'open')
            ->latest()
            ->get();

        return response()->json($projects);
    }

    // 🔓 Public can view single project details
    public function show($id)
    {
        $project = Project::with(['user', 'proposals.user'])->findOrFail($id);
        return response()->json($project);
    }

    // 🔒 Only logged-in users can create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'nullable|numeric',
            'deadline' => 'nullable|date',
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget' => $validated['budget'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
        ]);

        return response()->json($project, 201);
    }

    // 🔒 Only the project owner can update
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if ($project->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'budget' => 'nullable|numeric',
            'deadline' => 'nullable|date',
            'status' => 'in:open,in progress,completed',
        ]);

        $project->update($validated);

        return response()->json($project);
    }

    // 🔒 Only the project owner can delete
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
}
