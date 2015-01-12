<?php namespace App\Http\Controllers\Admin;

use App\Gateways\DbSiteSettingGateway;
use View, Input, Redirect, Session;

class SiteSettingsController extends AdminController
{
    protected $viewNamespace = 'admin.site-settings';

    protected $defaultTitle = 'Site Settings';

    /**
     * @var \App\Gateways\DbSiteSettingGateway
     */
    protected $setting;

    public function __construct(DbSiteSettingGateway $setting)
    {
        $this->setting = $setting;
    }

    public function edit()
    {
        $settings = $this->setting->all();

        return $this->render('edit', compact('settings'), 'Site Settings');
    }

    public function store()
    {
        $input = Input::except('_token');

        if ($this->setting->updateValuesForSlugs($input)) {
            return redirect()
                ->back()
                ->with('success', 'Settings Updated Successfully');
        }

        return redirect()->back()
            ->withInput(Input::except('_token'))
            ->withErrors()
            ->with('danger', 'Error Updating Settings')
            ->withErrors($this->setting->errors());
    }
}
