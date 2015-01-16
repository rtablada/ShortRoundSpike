<?php  namespace App\Providers;

use App\Gateways\ArrayMenuGateway;
use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider
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
        $menuDriver = $this->app['config']->get('short-round.menus.driver', 'array');
        $menusArray = $this->app['config']->get('menus');

        $this->app->bind('menu-array', function($app) use ($menusArray) {
            return new ArrayMenuGateway($menusArray);
        });
        $this->app->bind('App\\Gateways\\ArrayMenuGateway', 'menu-array');

        switch ($menuDriver) {
            case 'db':
                $this->app->bind('App\\Gateways\\MenuGatewayInterface', 'App\\Gateways\\DbMenuGateway');
                break;
            default:
                $this->app->bind('App\\Gateways\\MenuGatewayInterface', 'App\\Gateways\\ArrayMenuGateway');
                break;
        }


    }
}
