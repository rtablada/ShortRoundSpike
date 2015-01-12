<?php

use Rtablada\ShortRound\Database\EloquentSeeder;

class MenuSeeder extends EloquentSeeder
{

    protected $model = 'App\Models\Menu';

    protected $seeds = [
        [
            'name'     => 'Admin',
            'base_url' => '/admin',
            'children' => [
                [
                    'name' => 'Users',
                    'url'  => 'users'
                ],
                [
                    'name' => 'Copy',
                    'url'  => 'copy'
                ],
            ],
        ]
    ];

}
