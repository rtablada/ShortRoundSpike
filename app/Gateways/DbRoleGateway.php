<?php  namespace App\Gateways;

use App\Models\Role;

class DbRoleGateway
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        return $this->role->newQuery()->get();
    }
}
