<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role_id)
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'Unauthorized'); 
        }

        foreach ($role_id as $id) {
            if ($user->role->contains('id', $id)) {
                return $next($request);
            }
        }

        abort(403, 'Access is restricted'); 
    }
}
