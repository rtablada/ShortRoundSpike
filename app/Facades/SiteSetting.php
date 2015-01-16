<?php  namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SiteSetting extends Facade
{
    public static function get($slug)
    {
        $setting = static::$app[static::getGatewayClass()]->forSlug($slug);

        return $setting ? $setting->value : null;
    }

    protected static function getFacadeAccessor() { return static::getGatewayClass(); }

    protected static function getGatewayClass()
    {
        return static::$app['config']->get('short-round.gateways.site-settings');
    }
}
