<?php  namespace App\Gadgets;

use App\Gateways\DbMenuGateway;
use App\Gateways\MenuGatewayInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\Factory;

class Menus
{
    /**
     * @var \App\Gateways\MenuGatewayInterface
     */
    protected $menu;

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $auth;

    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    protected $template = 'gadgets.menus';

    public function __construct(MenuGatewayInterface $menu, Factory $view, Guard $auth)
    {
        $this->menu = $menu;
        $this->view = $view;
        $this->auth = $auth;
    }

    public function render($slug, $options = [])
    {
        $menus = $this->menu->childrenForSlug($slug);
        $user = $this->auth->user();

        \Log::info($user);

        return $this->view->make($this->getTemplateName($options), compact('menus', 'user'));
    }

    protected function getTemplateName($options)
    {
        return isset($options['template']) ? $options['template'] : $this->template;
    }
}
