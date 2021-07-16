<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user('api')->is_admin) {
            $tasks = Task::all();
        } else {
            $user = auth()->user('api');
            $tasks = Task::where('assigner_id', $user->id)->orWhere('assignee_id', $user->id)->get();
        }
        return response(['task' => TaskResource::collection($tasks), 'message' => 'Retrieved Successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user('api');
        $request->request->assigner_id = auth()->user('api')->id;
        $data = $request->all();
        $data['assigner_id'] = auth()->user('api')->id;
        if (!$user->is_admin && $user->id != $data['assignee_id']) {
            $data['assignee_id'] = null;
        }
        $validator = Validator::make($data, [
            'title' => 'required',
        ]);
        if ($validator->failed()) {
            return response(['errors' => $validator->errors(), 'message' => 'Error occurred'], 400);
        }

        $task = Task::create($data);

        return response(['task' => new TaskResource($task), 'message' => 'Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $user = auth()->user('api');
        if (!$user->is_admin && $user->id != $task->assigner_id && $user->id != $task->assignee_id) {
            return response(['message' => 'Unauthorized'], 403);
        }
        return response(['task' => new TaskResource($task), 'message' => 'Retrieved Successfully']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $user = auth()->user('api');
        if ($user->id != $task->assigner_id) {
            return response(['message' => 'Unable to update'], 403);
        }
        $task->update($request->all());
        $task->assigner_id = $user->id;
        if (!$user->is_admin && $user->id != $task->assignee_id) {
            $task->assignee_id = null;
        }
        $task->save();

        return response(['task' => new TaskResource($task), 'message' => 'Update Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $user = auth()->user('api');
        if ($user->id != $task->assigner_id) {
            return response(['message' => 'Unable to delete.'], 403);
        }
        $task->delete();

        return response(['message' => 'Deleted'],204);
    }
}
