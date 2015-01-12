<?php  namespace App\Gateways;

use App\Models\User;

class DbUserGateway
{
    /**
     * @var \App\Models\User
     */
    protected $menu;

    public function __construct(User $menu)
    {
        $this->menu = $menu;
    }

    public function all()
    {
        return $this->menu->newQuery()
            ->get();
    }

    public function find($id)
    {
        return $this->menu->newQuery()
            ->where('id', $id)
            ->first();
    }

    public function update($id, array $attributes = [])
    {
        $menu = $this->find($id);

        $menu->update($attributes);

        return $menu;
    }

}
