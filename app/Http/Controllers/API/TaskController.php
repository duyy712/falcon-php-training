<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:api', 'role', 'scope:admin']);
    //     $this->middleware(['auth:api', 'role', 'scope:user'])->only('index');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return response(['task' => TaskResource::collection($tasks), 'message' => 'Retrieved Successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
        ]);
        if ($validator->failed()) {
            return response(['errors' => $validator->errors(), 'message' => 'Error occured']);
        }

        $task = Task::create($data);

        return response(['task' => new TaskResource($task), 'message' => 'Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::where('id', $id)->first();

        return response(['task' => new TaskResource($task), 'message' => 'Retrieved Successfully']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response(['task' => new TaskResource($task), 'message' => 'Retrieved Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response(['message' => 'Deleted']);
    }
}
