<?php namespace App\Http\Controllers\Admin;

use App\Gateways\DbMenuGateway;

class MenusController extends AdminController
{
    protected $viewNamespace = 'admin.menus';

    protected $defaultTitle = 'Menus';

    /**
     * @var Menu
     */
    protected $menu;

    /**
     * @param DbMenuGateway $menu
     */
    public function __construct(DbMenuGateway $menu)
    {
        $this->menu = $menu;
    }

    public function index()
    {
        $menus = $this->menu->parentsOnly();

        return $this->render('index', compact('menus'));
    }

    public function show($slug)
    {
        $menus = $this->menu->childrenForSlug($slug);
        $parent = $this->menu->forSlug($slug);

        return $this->render('show', compact('menus', 'parent'), "Menus - $slug");
    }
}
