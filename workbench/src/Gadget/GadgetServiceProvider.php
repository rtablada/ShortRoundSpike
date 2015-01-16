<?php  namespace Rtablada\ShortRound\Gadget;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class GadgetServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gadget', function ($app) {
            return new GadgetFactory($app);
        });
    }

    public function boot()
    {
        $app = $this->app;
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(function($view, BladeCompiler $compiler) {
            $pattern = $compiler->createMatcher('gadget');

            return preg_replace($pattern, '<?php echo app(\'gadget\')->make$2; ?>', $view);
        });

        $aliases = $this->app['config']->get('gadgets.aliases', []);

        $this->app['gadget']->registerAliases($aliases);
    }

    public function provides()
    {
        return ['gadget'];
    }
}
