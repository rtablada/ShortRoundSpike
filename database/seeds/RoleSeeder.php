<?php

use Rtablada\ShortRound\Database\EloquentSeeder;

class RoleSeeder extends EloquentSeeder
{

    protected $model = 'App\Models\Role';

    protected $seeds = [
        [
            'name' => 'admin',
        ],
    ];

}
