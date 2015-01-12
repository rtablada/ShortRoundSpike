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
                    'url'  => 'users',
                ],
                [
                    'name' => 'Menus',
                    'url'  => 'menus',
                ],
                [
                    'name' => 'Copy',
                    'url'  => 'copy',
                ],
                [
                    'name' => 'Settings',
                    'url'  => 'site-settings',
                ],
            ],
        ],
        [
            'name'     => 'Admin Top',
            'base_url' => '/admin',
            'children' => [
                [
                    'name' => 'Settings',
                    'url' => 'site-settings',
                    'class' => 'fa fa-cog fa-fw',
                ],
                [
                    'name' => 'Users',
                    'url'  => 'users',
                    'class' => 'fa fa-user fa-fw',
                    'children' => [
                        [
                            'name' => 'Logout',
                            'url'  => '/logout',
                            'class' => 'fa fa-sign-out fa-fw'
                        ],
                        [
                            'name' => 'Profile',
                            'url'  => 'users/profile',
                            'class' => 'fa fa-user fa-fw'
                        ],
                    ]
                ],
            ]
        ],
    ];

}
