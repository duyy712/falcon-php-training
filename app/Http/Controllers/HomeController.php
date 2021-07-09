<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function redirect()
    {
        if (!auth()->check()) {
            return redirect()->to('/login');
        }
        return redirect('/dashboard');
    }

    public function task_list()
    {
        $user = auth()->user();
        if ($user->is_admin) {
            $data = Task::all();
        } else {
            $id = $user->id;
            $data = Task::where('assignee_id', $id)->orWhere('assigner_id', $id)->get();
        }

        return view('app', ['tasks' => $data]);
    }
}
