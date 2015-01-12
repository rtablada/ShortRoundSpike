<?php  namespace Rtablada\ShortRound\Gadget;

use Illuminate\Foundation\Application;

class GadgetFactory
{
    /**
     * @var \Illuminate\Contracts\Console\Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function make($class)
    {
        $gadget = $this->app->make($class);

        $args = func_get_args();
        array_shift($args);

        return call_user_func_array([$gadget, 'render'], $args);
    }
}
