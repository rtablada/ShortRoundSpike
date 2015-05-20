<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use BeatSwitch\Lock\Callers\Caller;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use BeatSwitch\Lock\LockAware;
use Rtablada\ShortRound\Helpers\LockDbRoleTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, Caller
{

    use Authenticatable, CanResetPassword, LockDbRoleTrait, LockAware;

    protected $roleClass = Role::class;

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

    public function inRoles(array $keys)
    {
        foreach ($keys as $key) {
            if ($this->hasRole($key)) {
                return true;
            }
        }
    }

    public function getCallerType()
    {
        return 'users';
    }

    public function getCallerId()
    {
        $this->id;
    }

}
