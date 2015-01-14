<?php  namespace App\Models;

use Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lookitsatravis\Listify\Listify;

class Copy extends Model
{
    protected $table = 'copy';

    protected $fillable = [
        'name',
        'value',
    ];

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

    public function getShortAttribute()
    {
        return Str::words($this->attributes['value'], 10);
    }

}
