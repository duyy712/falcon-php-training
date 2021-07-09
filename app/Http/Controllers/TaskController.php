<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //     //
        
        $tables =   DB::table('users')->get(['id', 'name']);
        $statuses = DB::table('statuses')->get(['id', 'name']);
        $task = new Task();
        $method = "POST";
        //     //dd($tables[0]);
        //dd(compact('tables','statuses'));
        return view('result', compact('task', 'tables', 'statuses', 'method'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $disabled = !auth()->user()->is_admin ? 1:0;
        $tables =   DB::table('users')->get(['id', 'name']);
        $statuses = DB::table('statuses')->get(['id', 'name']);
        $task = DB::table('tasks')->where('id', '=', $id)->first();
        $method = 'PUT';

        return view('result', compact('disabled','tables', 'statuses', 'task', 'method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $task = DB::table('tasks')->where('id', '=', $request->id);
        $task->update($request->except(['_token', '_method']));
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
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
