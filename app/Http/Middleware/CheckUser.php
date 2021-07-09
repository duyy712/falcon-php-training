<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Task;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()) {
            return abort(404);
        } else {
            $user = auth()->user();
            $task = Task::where('id', $request->route()->parameters()['id'])->get()->first();

            if (
                $user->id !== $task->assignee_id && $user->id !== $task->assigner_id && !auth()->user()->is_admin
            ) {
                return abort(404);
            }
        }
        return $next($request);
    }
}
