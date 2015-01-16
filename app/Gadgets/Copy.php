<?php  namespace App\Gadgets;

use App\Gateways\DbCopyGateway;

class Copy
{
    /**
     * @var \App\Gateways\DbCopyGateway
     */
    protected $copy;

    public function __construct(DbCopyGateway $copy)
    {
        $this->copy = $copy;
    }

    public function render($slug, $options = [])
    {
        $copy = $this->copy->forSlug($slug);

        return $copy->value;
    }
}
