<?php  namespace App\Exceptions;

use Exception;

class InvalidPermissionException extends Exception
{
    /**
     * @var string
     */
    public $action;
    /**
     * @var int
     */
    public $resource;

    public function __construct($action, $resource)
    {
        $this->action = $action;
        $this->resource = $resource;
    }
}
