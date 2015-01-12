<?php namespace Rtablada\ShortRound\Database;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Application;

abstract class EloquentSeeder extends Seeder
{

    protected $table;

    protected $model;

    protected $seeds = [];

    protected $truncate = true;

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $db;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected  $app;

    public function __construct(DatabaseManager $db, Application $app)
    {
        $this->db = $db;
        $this->app = $app;
    }

    public function run()
    {
        if ($this->truncate) {
            $this->db->connection()
                ->table($this->getTableName())
                ->truncate();
        }

        foreach ($this->seeds as $seed) {
           $this->getModelInstance()->create($seed);
        }
    }


    /**
     * Returns instance of Model from App Container
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModelInstance()
    {
        return  $this->app->make($this->model);
    }

    protected function getTableName()
    {
        return $this->table ?: $this->getModelInstance()->getTable();
    }

}
