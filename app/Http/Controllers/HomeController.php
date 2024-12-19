<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('home');
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

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);


        ToDo::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'priority' => $validatedData['priority'],
            'status' => 'To Do',
            'user_id' => auth()->id(),
        ]);

        return redirect('/task')->with('success', 'Task added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = ToDo::findOrFail($id);


        if ($task->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
        }

        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = ToDo::findOrFail($id);

        if ($task->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
        }

        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'status' => 'required|string|in:To Do,In Progress,Done',
        ]);

        $task = ToDo::findOrFail($id);


        if ($task->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to update this task.'], 403);
        }


        $task->status = $validatedData['status'];
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task status updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $task = ToDo::findOrFail($id);


        if ($task->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to delete this task.'], 403);
        }


        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
