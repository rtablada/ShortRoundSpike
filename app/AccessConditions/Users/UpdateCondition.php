<?php namespace App\AccessConditions\Users;

use App\Models\User;
use BeatSwitch\Lock\Lock;
use BeatSwitch\Lock\Permissions\Condition;
use BeatSwitch\Lock\Permissions\Permission;
use BeatSwitch\Lock\Resources\Resource;

class UpdateCondition implements Condition
{

    /**
     * Assert if the condition is correct
     *
     * @param \BeatSwitch\Lock\Lock $lock
     * @param \BeatSwitch\Lock\Permissions\Permission $permission
     * @param string $action
     * @param \BeatSwitch\Lock\Resources\Resource|null $resource
     * @return bool
     */
    public function assert(Lock $lock, Permission $permission, $action, Resource $resource = null)
    {
        $user = $lock->getSubject();
        $id = (int)$resource->getResourceId();
        $userId = (int)$user->id;

        if ($user instanceof User) {
            return $user->hasRole('admin') || $userId === $id;
        }
    }
}
