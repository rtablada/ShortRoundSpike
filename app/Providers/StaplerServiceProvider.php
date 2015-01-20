<?php namespace App\Providers;

use Config;
use Illuminate\Support\ServiceProvider;
use Codesleeve\LaravelStapler\Services\ImageRefreshService;
use Codesleeve\Stapler\Stapler;
use Codesleeve\Stapler\Config\NativeConfig;

class StaplerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootstrapStapler();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Bootstrap up the stapler package:
     * - Boot stapler.
     * - Set the config driver.
     * - Set public_path config using laravel's public_path() method (if necessary).
     * - Set base_path config using laravel's base_path() method (if necessary).
     *
     * @return void
     */
    protected function bootstrapStapler()
    {
        Stapler::boot();

        $config = new NativeConfig($this->app['config']->get('stapler'));

        Stapler::setConfigInstance($config);

        if (!$config->get('stapler.public_path')) {
            $config->set('stapler.public_path', realpath(public_path()));
        }

        if (!$config->get('stapler.base_path')) {
            $config->set('stapler.base_path', realpath(base_path()));
        }
    }

}
