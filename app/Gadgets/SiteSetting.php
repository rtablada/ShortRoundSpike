<?php  namespace App\Gadgets;

use App\Gateways\DbSiteSettingGateway;

class SiteSetting
{
    /**
     * @var \App\Gateways\DbCopyGateway
     */
    protected $setting;

    public function __construct(DbSiteSettingGateway $setting)
    {
        $this->setting = $setting;
    }

    public function render($slug, $options = [])
    {
        $setting = $this->setting->forSlug($slug);

        return $setting->value;
    }
}
