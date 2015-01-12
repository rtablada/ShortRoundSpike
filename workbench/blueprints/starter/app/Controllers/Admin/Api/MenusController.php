<?php namespace App\Http\Controllers\Admin\Api;

use App\Gateways\DbMenuGateway;
use Illuminate\Routing\Controller;

class MenusController extends Controller
{
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
        return $this->menu->all();
    }
}
