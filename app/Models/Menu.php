<?php  namespace App\Models;

use Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lookitsatravis\Listify\Listify;

class Menu extends Model
{
    use Listify;

    protected $queuedChildren = [];

    protected $appends = [
        'full_url',
    ];

    /**
     * Create a new Eloquent model instance and attach Listify
     *
     * @param  array $attributes
     * @return Menu
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $lisifyOptions = [];

        if ($this->getAttribute('parent_id')) {
            $lisifyOptions['scope'] = $this->parent();
        }

        $this->initListify($lisifyOptions);
    }


    /**
     * Boot Model instance and add Event listener
     * that will save children menus if needed
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $model->createChildren();
        });
    }

    /**
     * Creates parent relationship for Menu nesting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parent()
    {
        return $this->belongsTo('App\\Models\\Menu', 'parent_id');
    }

    /**
     * Creates children relationship for Menu nesting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\\Models\\Menu', 'parent_id');
    }

    /**
     * Sets name attribute and creates
     * a slug param if none exists
     *
     * @param string $value
     *
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        if (!isset($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Queues children to be
     * created after save
     *
     * @param array $children
     *
     * @return void
     */
    public function setChildrenAttribute(array $children)
    {
        $this->queuedChildren = $children;
    }


    /**
     * Creates children from queue
     *
     * @return void
     */
    public function createChildren()
    {
        foreach ($this->queuedChildren as $childAttrs) {
            $childAttrs['parent_id'] = $this->getAttribute('id');

            $child = static::create($childAttrs);
        }
    }

    public function getFullUrlAttribute()
    {
        if ($this->parent && substr($this->url, 0, 1) !== '/') {
            \Log::info($this->parent);
            return $this->parent->getFullUrlAttribute() . '/' . $this->url;
        } else {
            return  $this->url;
        }
    }

    public function getRolesAttribute()
    {
        return explode(',', $this->attributes['roles']);
    }

    public function setRolesAttribute($value)
    {
        $this->attributes['roles'] = implode(',', $value);
    }

    public function isActive()
    {
        return '/' . Request::path() === $this->getFullUrlAttribute();
    }

}
