<?php  namespace App\Services;

use App\Exceptions\InvalidPermissionException;

trait AssertsPermission
{
    protected function assertPermission($action, $id = null)
    {
        if (!$this->getAuthenticatedUser()->can($action, $this->resourceType, $id)) {
            throw new InvalidPermissionException($action, $this->resourceType);
        }
    }


    /**
     * @return \App\Models\User
     */
    protected function getAuthenticatedUser()
    {
        return app('auth')->user();
    }
}
