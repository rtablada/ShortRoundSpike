<?php  namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lookitsatravis\Listify\Listify;

class Menu extends Model
{
    use Listify;

    protected $queuedChildren = [];

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

//        $this->query()->where('parent_id', '=', $this->getAttribute('parent_id'))

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

}
