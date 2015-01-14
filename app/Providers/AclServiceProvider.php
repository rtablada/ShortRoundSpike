<?php  namespace App\Providers;

use Authority\Authority;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    public function boot()
    {
        $this->app['authority'] = $this->app->share(function($app){
            $user = $app['auth']->user();
            $authority = new Authority($user);
            $fn = $app['config']->get('acl.initialize', null);

            if($fn) {
                $fn($authority);
            }

            return $authority;
        });

        $this->app->alias('Authority/Authority', 'authority');
    }
}
