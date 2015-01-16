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
        if ($cacheResult = $this->getRoleCache($key)) {
            return $cacheResult;
        }

        $roleMatch = $this->roles()
                ->where('name', '=', $key)
                ->count();

        $this->putRoleCache($key, $roleMatch);

        return $roleMatch !== 0;
    }

    public function ensureRole($key)
    {
        if (!$this->hasRole($key)) {
            $role = $this->findRole($key);

            $this->roles()->attach($role);
            $this->forgetRoleCache($key);
        }
    }

    public function detachRole($key)
    {
        $role = $this->findRole($key);

        $this->roles()->detach($role->id);
        $this->forgetRoleCache($key);
    }

    public function getRoleModel()
    {
        return $this->roles()->getRelated();
    }

    /**
     * @param $key
     * @return static
     */
    protected function findRole($key)
    {
        $role = $this->getRoleModel()->firstOrCreate(['name' => $key]);
        return $role;
    }

    protected function getRoleCache($roleName)
    {
        $cache = $this->getCacheInstance();

        return $cache->get($this->getCacheKey($roleName));
    }

    protected function putRoleCache($roleName, $roleMatch)
    {
        $cache = $this->getCacheInstance();

        $cache->put($this->getCacheKey($roleName), $roleMatch, 60);
    }

    protected function forgetRoleCache($roleName)
    {
        $cache = $this->getCacheInstance();

        $cache->forget($this->getCacheKey($roleName));
    }

    protected function getCacheKey($key)
    {
        return "hasRole.{$this->getAttribute('id')}.{$key}";
    }


    /**
     *
     * @return \Illuminate\Cache\Repository
     */
    protected function getCacheInstance()
    {
        return app('cache');
    }

}
