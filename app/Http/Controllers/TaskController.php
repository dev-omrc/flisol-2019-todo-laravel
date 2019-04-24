<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = auth()->user()->tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'name' => $task->name,
                'completed' => $task->completed,
                'created_at' => $task->created_at->diffForHumans()
            ];
        });

        return response()->json([
            'tasks' => $tasks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $task = new Task;
        $task->name = $request->name;

        auth()->user()->tasks()->save($task);

        return response()->json([
            'message' => 'Task created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response()->json([
            'task' => [
                'id' => $task->id,
                'name' => $task->name,
                'completed' => $task->completed,
                'created_at' => $task->created_at->diffForHumans()
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required_without:completed|min:3',
            'completed' => 'required_without:name|boolean'
        ]);

        if ($request->name) {
            $task->name = $request->name;
        }

        if (isset($request->completed)) {
            $task->completed = $request->completed;
        }

        $task->save();

        return response()->json([
            'message' => 'Task updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([], 204);
    }
}
