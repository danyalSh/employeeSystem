<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RolesAndPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->route()->getAction()['as'] == 'reports'){
            if(!\Auth::user()->isAssigned($request->route()->id) && \Auth::user()->hasRole('User')){
                return redirect('/404');
            }
        }

        $action = $request->route()->getAction();
        $permission = $action['permission'];
        if (\Auth::user() && \Auth::user()->hasPermission($permission)) {
            return $next($request);
        }
        return redirect('/404');
    }
}
