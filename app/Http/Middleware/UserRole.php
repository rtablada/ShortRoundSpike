<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserRole
{

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = 'admin')
    {
        // This is a work around until 5.1 middleware params
        $routeParams = $request->route()->getAction();
        $role = isset($routeParams['role']) ? $routeParams['role'] : $role;

        if ($request->user() && $request->user()->hasRole($role)) {
            return $next($request);
        }

        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        } else {
            return redirect()->guest(route('admin.dashboard.index'))
                ->with('warning', 'You should not be here.');
        }
    }

}
