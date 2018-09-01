<?php

namespace App\Http\Middleware;

use App\Roles;
use Closure;
use \WebsolutionsGroup\Auth\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $role = Roles::where('name', $role)->first();
        if(is_null($role) && Auth::check() == false || Auth::user()->getPivot('roles', $role) === false) {
            return redirect('/');
        }
        
        return $next($request);
    }
}
