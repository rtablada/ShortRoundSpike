<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;

class Pages
{

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    private $config;

    /**
     * @var array
     */
    protected $pages;
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    private $view;

    public function __construct(Repository $config, Factory $view)
    {
        $this->pages = $config->get('pages.pages', []);

        $this->view = $view;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uri = $request->path();

        if (isset($this->pages[$uri])) {
            return response(view($this->pages[$uri]), 200);
        }

        return $next($request);
    }


    protected function getTemplateName($uri)
    {
        return $this->config->get('pages.pages')[$uri];
    }

}
