<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
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
        dd($request);
      
        $role =$request->user();
        if ($role->is_admin) {
            dd(1);
            $request->request->add(['scope' => 'admin']);
        } else {
            dd(0);
            $request->request->add(['scope' => 'user']);
        }


        return $next($request);
    }
}
