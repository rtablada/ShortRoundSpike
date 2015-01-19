<?php namespace Rtablada\ShortRound\Generator;

use Illuminate\Support\Str;

class GeneratorInput
{
    protected $attributes = [];

    protected $arrayableFields = [
        'fields',
        'attachments',
        'controllerPath',
        'modelPath',
        'gatewayPath',
        'modelUpper',
        'modelUpperPlural',
        'modelVar',
        'modelPlural',
        'tableName',
        'dashedPlural',
        'migrationName',
        'viewsDir',
        'attachments',
        'columns',
        'position',
        'timestamps',
        'increments',
    ];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function getControllerPath()
    {
        $controllerName = $this->modelUpperPlural . 'Controller.php';

        return 'Http/Controllers/Admin/' . $controllerName;
    }

    public function getModelPath()
    {
        $modelName = $this->modelUpper . '.php';

        return 'Models/' . $modelName;
    }

    public function getGatewayPath()
    {
        $gatewayName = 'Db' . $this->modelUpper . 'Gateway.php';

        return 'Gateways/' . $gatewayName;
    }

    public function getModelUpperPlural()
    {
        return Str::plural($this->modelUpper);
    }

    public function getModelVar()
    {
        return Str::camel($this->modelUpper);
    }

    public function getModelPlural()
    {
        return Str::plural($this->getModelVar());
    }

    public function getTableName()
    {
        return Str::snake($this->modelUpperPlural);
    }

    public function getDashedPlural()
    {
        return str_replace('_', '-', $this->tableName);
    }

    public function getMigrationName()
    {
        return 'create_' . $this->tableName . '_table';
    }

    public function getViewsDir()
    {
        return 'resources/views/admin/' . $this->dashedPlural;
    }

    public function getAttachments()
    {
        $results = array_filter($this->fields, function ($item) {
            return isset($item['type']) && $item['type'] === 'file';
        });

        return array_values($results);
    }

    public function getColumns()
    {
        $results = array_filter($this->fields, function ($item) {
            return isset($item['type']) && $item['type'] !== 'file';
        });

        return array_values($results);
    }

    public function toArray()
    {
        $attrs = $this->attributes;

        foreach($this->arrayableFields as $field) {
            $attrs[$field] = $this->__get($field);
        }

        return $attrs;
    }

    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
        if ($this->accessorExists($key)) {
            return $this->runAccessor($key);
        }
    }

    protected function accessorExists($key)
    {
        $accessorName = $this->getAccessorName($key);

        return method_exists($this, $accessorName);
    }

    protected function getAccessorName($key)
    {
        return 'get' . ucwords($key);
    }

    protected function runAccessor($key)
    {
        $accessorName = $this->getAccessorName($key);

        return call_user_func([$this, $accessorName]);
    }

}
