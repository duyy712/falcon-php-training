<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->users = User::all();
        $this->statuses = Status::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disabled = auth()->user()->is_admin ? 0 : 1;
        $users = $this->users;
        $statuses = $this->statuses;
        $task = new Task();
        $method = 'POST';

        return view('task', ['users' => $users, 'statuses' => $statuses, 'method' => $method, 'disabled' => $disabled, 'task' => $task]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assignee_id' => $request->assignee_id,
            'status_id' => $request->status_id,
            'assigner_id' => $user->id,
        ]);

        event(new Registered($task));

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = $this->users;
        $statuses = $this->statuses;

        $disabled = auth()->user()->is_admin ? 0 : 1;
        $task = Task::where('id', $id)->first();
        $method = 'PUT';

        return view('task', ['users' => $users, 'statuses' => $statuses, 'method' => $method, 'disabled' => $disabled, 'task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->assignee_id = $request->assignee_id;
        $task->status_id = $request->status_id;
        $task->save();

        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from tasks where id =?', [$id]);
        //
        //dd($id);
        //$task = Task::where('id',$id);
        //dd($task->delete());
        //  $task->delete();
        return redirect('/dashboard');
    }
}
