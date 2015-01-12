<?php  namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

abstract class AdminController extends Controller
{
    protected $viewNamespace;

    protected $defaultTitle;

    public function render($method, $data, $title = null)
    {
        $title = $title ?: $this->defaultTitle;

        if (!isset($data['title'])) {
            $data['title'] = $title;
        }

        return view($this->viewNamespace . '.' . $method, $data);
    }
}
