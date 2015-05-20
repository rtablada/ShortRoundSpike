<?php  namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

class LockMiddleware
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->auth->user();
        if ($user) {
            $manager = app('lock.manager');
            $lock = $manager->caller($user);

            $user->setLock($lock);
        }

        return $next($request);
    }
}
