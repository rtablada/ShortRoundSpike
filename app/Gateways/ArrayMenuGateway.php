<?php  namespace App\Gateways;

use App\Models\ArrayMenuItem;
use Illuminate\Support\Collection;

class ArrayMenuGateway implements MenuGatewayInterface
{


    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    public function __construct(array $items)
    {
        $arr = [];

        foreach($items as $attrs) {
            $arr[] = new ArrayMenuItem($attrs);
        }

        $this->items = new Collection($arr);
    }

    public function all()
    {
        return $this->items;
    }

    public function parentsOnly()
    {
        return $this->items;
    }

    public function childrenForSlug($slug)
    {
        $parent = $this->forSlug($slug);

        if ($parent) {
            return $parent->children;
        }

        return [];
    }

    public function forSlug($slug)
    {
        return $this->items->first(function ($key, $item) use ($slug) {
            return $item->slug === $slug;
        });
    }
}
