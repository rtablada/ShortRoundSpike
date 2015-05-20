<?php namespace Rtablada\ShortRound\Helpers;

trait LockDbRoleTrait
{
    /**
     * Determine if a user has a given role
     *
     * @param  string $key
     * @return boolean
     */
    public function hasRole($key)
    {
        foreach ($this->roles as $role) {
            if ($role->name === $key) {
                return true;
            }
        }
        return false;
    }

    public function ensureRole($key)
    {
        if (!$this->hasRole($key)) {
            $role = $this->findRole($key);
            $this->roles()->attach($role);
        }
    }

    public function detachRole($key)
    {
        $role = $this->findRole($key);
        $this->roles()->detach($role->id);
    }

    public function getRoleModel()
    {
        return $this->roles()->getRelated();
    }

    /**
     * @param $key
     * @return Role
     */
    protected function findRole($key)
    {
        $role = $this->getRoleModel()->firstOrCreate(['name' => $key]);
        return $role;
    }

    /**
     * A user belongs to many roles
     *
     * @return belongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany($this->roleClass);
    }

    /**
     * The caller's roles
     *
     * @return array
     */
    public function getCallerRoles()
    {
        return $this->roles()->lists('name');
    }
}
