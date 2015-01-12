<?php  namespace App\Gateways;

use App\Models\Menu;

class DbMenuGateway
{
    /**
     * @var \App\Models\Menu
     */
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function all()
    {
        return $this->menu->newQuery()
            ->get();
    }

    public function parentsOnly()
    {
        return $this->menu->newQuery()
            ->where('parent_id', null)
            ->get();
    }

    public function childrenForSlug($slug)
    {
        $parent = $this->forSlug($slug);

        return $parent->children;
    }

    public function forSlug($slug)
    {
        return $this->menu->newQuery()
            ->where('slug', '=', $slug)
            ->first();

        return $parent->children;
    }
}
