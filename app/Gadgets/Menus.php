<?php  namespace App\Gadgets;

use App\Gateways\DbMenuGateway;

class Menus
{
    /**
     * @var \App\Gateways\DbMenuGateway
     */
    protected $menu;

    protected $template = 'gadgets.menus';

    public function __construct(DbMenuGateway $menu, \Illuminate\Contracts\View\Factory $view)
    {
        $this->menu = $menu;
        $this->view = $view;
    }

    public function render($slug, $options = [])
    {
        $menus = $this->menu->childrenForSlug($slug);

        return $this->view->make($this->getTemplateName($options), compact('menus'));
    }

    protected function getTemplateName($options)
    {
        return isset($options['template']) ? $options['template'] : $this->template;
    }
}
