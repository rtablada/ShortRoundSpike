<?php

use Rtablada\ShortRound\Database\EloquentSeeder;

class SiteSettingSeeder extends EloquentSeeder
{

    protected $model = 'App\Models\SiteSetting';

    protected $seeds = [
        [
            'name' => 'From Email',
            'value' => 'admin@example.com',
        ],
        [
            'name' => 'Address Street 1',
            'value' => '1234 1st Street',
        ],
        [
            'name' => 'Address Street 2',
            'value' => '',
        ],
        [
            'name' => 'Address City',
            'value' => 'Nashville',
        ],
        [
            'name' => 'Address State',
            'value' => 'TN',
        ],
        [
            'name' => 'Address Zip',
            'value' => '37201',
        ],
        [
            'name' => 'Facebook URL',
            'value' => 'foo',
        ]
    ];

}
