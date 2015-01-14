<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany('App\\Models\\Role');
    }

    public function permissions()
    {
        return $this->hasMany('App\\Models\\Permission');
    }

    public function hasRole($key)
    {
        $cache = app('cache');
        $id = $this->getAttribute('id');
        $cacheKey = "hasRole.{$id}.{$key}";

        if ($cacheResult = $cache->get($cacheKey)) {
            return $cacheResult;
        }

        $roleMatch = $this->roles()
                ->where('name', '=', $key)
                ->count();

        $cache->put($cacheKey, $roleMatch, 60);

        return $roleMatch !== 0;
    }

}
