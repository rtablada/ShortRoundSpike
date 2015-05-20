<?php  namespace App\Models;

use Illuminate\Support\Str;

class ArrayMenuItem
{
    protected $attributes;

    public $url;
    public $slug;
    public $name;
    public $base_url;
    public $full_url;
    public $class;
    public $regex;
    public $target;
    public $roles = [];
    public $children = [];

    protected $fillable = [
        'url',
        'slug',
        'name',
        'base_url',
        'class',
        'regex',
        'target',
        'roles',
    ];

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
        $this->boot();
    }

    protected function boot()
    {
        $this->setupAttrubtes();
        $this->setupSlug($this->name);
        $this->setupFullUrlAttribute($this->url, $this->base_url);

        if ($this->getAttribute('children')) {
            $this->setupChildren($this->full_url, $this->getAttribute('children'));
        }
    }

    public function getAttribute($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    protected function setupAttrubtes()
    {
        foreach($this->fillable as $field) {
            $this->$field = $this->getAttribute($field);
        }
    }

    protected function setupSlug($name)
    {
        if (!$this->slug) {
            $this->slug = Str::slug($name);
        }
    }

    protected function setupFullUrlAttribute($url, $baseUrl)
    {
        $baseUrl = preg_replace('/\/$/', '', $baseUrl);

        if ($baseUrl) {
            $this->full_url = $baseUrl . '/' . $url;
        } else {
            $this->full_url =  $url;
        }
    }

    protected function setupChildren($baseUrl, $children)
    {
        foreach ($children as $child) {
            $child['base_url'] = $baseUrl;

            $this->children[] = new static($child);
        }
    }

    public function isActive()
    {
        return true;
    }

}
