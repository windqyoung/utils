<?php

namespace Windqyoung\Utils\Artisan\Acl\Middleware;

use Closure;
use App\Services\Acl\AuchCheckFactory;
use Windqyoung\Utils\Artisan\Acl\AclAuthCheck;

class AclCheckMiddleware
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
        if (! $this->pass($request))
        {
            return response('Acl Unauthorized.', 401);
        }

        return $next($request);
    }

    protected function pass($request)
    {
        $routeName = \Route::currentRouteName();
        $method = $request->method();

        if (\Auth::guest())
        {
            return false;
        }

        $check = new AclAuthCheck(\Auth::id());

        return $check->canAccessRoute($routeName, $method);
    }
}
