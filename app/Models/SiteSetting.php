<?php  namespace App\Models;

use Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lookitsatravis\Listify\Listify;

class SiteSetting extends Model
{
    use Listify;

    protected $fillable = [
        'name',
        'value',
    ];

    /**
     * Create a new Eloquent model instance and attach Listify
     *
     * @param  array $attributes
     * @return SiteSetting
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->initListify();
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

}
