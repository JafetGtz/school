<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfOwns
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $entity, $resource)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (
            $user->is($entity) &&
            $user->userable
                ->{$resource . 's'}()
                ->where('id', $request->id)
                ->exists()
        ) {
            return $next($request);
        }

        return redirect()->route('dashboard.index');
    }
}
