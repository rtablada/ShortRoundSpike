<?php  namespace Rtablada\ShortRound\Gadget;

use Illuminate\Foundation\Application;

class GadgetFactory
{
    /**
     * @var \Illuminate\Contracts\Console\Application
     */
    private $app;

    protected $aliases = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function make($class)
    {
        $gadget = $this->app->make($this->getClass($class));

        $args = func_get_args();
        array_shift($args);

        return call_user_func_array([$gadget, 'render'], $args);
    }

    protected function getClass($class)
    {
        return isset($this->aliases[$class]) ? $this->aliases[$class] : $class;
    }

    public function registerAliases(array $aliases)
    {
        $this->aliases = array_merge($this->aliases, $aliases);
    }
}
