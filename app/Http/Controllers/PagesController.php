<?php  namespace App\Http\Controllers;

use Illuminate\Config\Repository;
use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function find($uri = '/')
    {
        return view($this->getTemplateName($uri));
    }

    protected function getTemplateName($uri)
    {
        return $this->config->get('pages.pages')[$uri];
    }
}
