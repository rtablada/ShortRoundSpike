<?php  namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class CopyServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        $copyGadgetClass = $this->app['config']->get('short-round.gadgets.copy');
        $app = $this->app;
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();


        if ($copyGadgetClass) {
            $blade->extend(function($view, BladeCompiler $compiler) use ($copyGadgetClass) {
                $pattern = $compiler->createMatcher('copy');

                return preg_replace($pattern, "<?php echo app('{$copyGadgetClass}')->render$2; ?>", $view);
            });
        }
    }


}
