<?php  namespace App\Gateways;

use App\Models\SiteSetting;

class DbSiteSettingGateway
{
    /**
     * @var \App\Models\SiteSetting
     */
    protected $setting;

    protected $errors = [];

    public function __construct(SiteSetting $setting)
    {
        $this->setting = $setting;
    }

    public function all()
    {
        return $this->setting->newQuery()
            ->orderBy('position')
            ->get();
    }

    public function forSlug($slug)
    {
        return $this->setting->newQuery()
            ->where('slug', '=', $slug)
            ->first();
    }

    public function updateForSlug($slug, $value)
    {
        $setting = $this->forSlug($slug);

        $setting->value = $value;
        return $setting->save();
    }

    public function updateValuesForSlugs($settings)
    {
        foreach($settings as $slug => $value) {
            if (!$this->updateForSlug($slug, $value)) {
                $this->errors[] = $slug;
            }
        }

        if (!count($this->errors)) {
            return true;
        }
    }

    public function errors()
    {
        return array_map(function ($key) {
            return true;
        }, array_flip($this->errors));
    }

    public function newInstance($attrs = [])
    {
        return $this->setting->newInstance($attrs);
    }

    public function create($attrs = [])
    {
        $setting = $this->newInstance($attrs);

        $setting->save();

        return $setting;
    }
}
