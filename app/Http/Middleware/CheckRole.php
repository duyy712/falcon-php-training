<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $role = $request->user('api');
        if ($role->is_admin) {
            $request->request->add(['scope' => 'admin']);
        } else {
            $request->request->add(['scope' => 'user']);
        }

        return $next($request);
    }
}
