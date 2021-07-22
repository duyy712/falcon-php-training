<?php

namespace App\Http\Controllers;

use App\Jobs\SendAssignMail;
use App\Models\Task;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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

    public function sendMail()
    {
        $job = new SendAssignMail();
        dispatch($job);
        // dd('done');
    }

    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            //dump($lang);
            Session::put('applocale', $lang);

            App::setLocale($lang);
            // dd(App::getLocale());
        }

        return Redirect::back();
    }
}
