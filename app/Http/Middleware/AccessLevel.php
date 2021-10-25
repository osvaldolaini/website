<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AccessLevel
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! Auth::check()) {
            return route('login');
        }

        if ($role < Auth::user()->group->level) {
            $url = $request->fullUrl();
            $method = $request->getMethod();
            $user=Auth::user()->name;
            $log = "{$user} tentou acessar área que seu perfil não tem acesso {$method}@{$url}";
            Log::notice($log);

            return redirect()->route('admin.home');
        }

        return $next($request);
    }
}
