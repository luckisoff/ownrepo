<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
  public function handle($request, Closure $next)
  {
    $actions = $request->route()->getAction();
    $roles = $actions['roles'];
    foreach ($roles as $role) {
      // only give access to the people with the roles assigned in the route group roles
      if (Auth::user()->hasRole($role))
        return $next($request);
    }
    return redirect(route('admin_home'))->with('failure_message', 'Access Denied.');
  }
}
