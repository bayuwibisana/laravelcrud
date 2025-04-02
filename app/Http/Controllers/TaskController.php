<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::orderBy('priority')->get();
        $projects = Project::orderBy('id')->get();
        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'project_id' => 'integer',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }


    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'project_id' => 'integer',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function filter(Request $request)
    {

        $selectedProject = $request->input('project_id');
        $projects = Project::orderBy('id')->get();

        $tasks = Task::when($selectedProject, function ($query, $selectedProject) {
            return $query->where('project_id', $selectedProject);
        })->orderBy('priority')->get();

        return view('tasks.index', compact('tasks', 'projects', 'selectedProject'));
    }

    public function updateOrder(Request $request)
    {
        $taskIds = $request->input('taskIds');

        try {
            foreach ($taskIds as $index => $taskId) {
                Task::where('id', $taskId)->update(['priority' => $index + 1]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
