<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');
        $priorityFilter = $request->input('priority');


        $tasks = ToDo::where('user_id', auth()->id())
            ->whereIn('status', ['To Do', 'In Progress'])
            ->orderBy('created_at', 'desc');


        if ($search) {
            $tasks = $tasks->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }


        if ($statusFilter) {
            $tasks = $tasks->where('status', $statusFilter);
        }

        if ($priorityFilter) {
            $tasks = $tasks->where('priority', $priorityFilter);
        }


        $tasks = $tasks->get();


        if ($request->ajax()) {
            return view('partials.task-list', compact('tasks'));
        }

        return view('task', compact('tasks', 'search', 'statusFilter', 'priorityFilter'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = ToDo::findOrFail($id);


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string|in:low,medium,high',
            'due_date' => 'required|date',
            'status' => 'required|string|in:To Do,In Progress,Done',
        ]);


        $task->update($validated);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }


    public function destroy(string $id)
    {

        $task = ToDo::findOrFail($id);

        if ($task->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to delete this task.'], 403);
        }


        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
    public function doneTasks(Request $request)
    {
        $search = $request->input('search');
        $priorityFilter = $request->input('priority');


        $tasks = ToDo::where('user_id', auth()->id())
            ->where('status', 'Done')
            ->orderBy('created_at', 'desc');


        if ($search) {
            $tasks = $tasks->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }


        if ($priorityFilter) {
            $tasks = $tasks->where('priority', $priorityFilter);
        }

        $tasks = $tasks->get();

        if ($request->ajax()) {
            return view('partials.task-list', compact('tasks'));
        }

        return view('task-done', compact('tasks', 'search', 'priorityFilter'));
    }
}
