<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
        ]);

        Project::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Project created successfully.');
    }
}
