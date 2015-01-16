<?php  namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class SiteSettingsServiceProvider extends ServiceProvider
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
        $siteSettingGadgetClass = $this->app['config']->get('short-round.gadgets.site-settings');
        $app = $this->app;
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();


        if ($siteSettingGadgetClass) {
            $blade->extend(function($view, BladeCompiler $compiler) use ($siteSettingGadgetClass) {
                $pattern = $compiler->createMatcher('setting');

                return preg_replace($pattern, "<?php echo app('{$siteSettingGadgetClass}')->render$2; ?>", $view);
            });
        }
    }


}
