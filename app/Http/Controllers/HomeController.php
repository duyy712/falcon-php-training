<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
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
            $tasks = Task::all();
        } else {
            $id = $user->id;
            $tasks = Task::where('assignee_id', $id)->orWhere('assigner_id', $id)->get();
        }

        return view('dashboard', ['tasks' => $tasks]);
    }
}
