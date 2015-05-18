<?php  namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    public function home()
    {
        $title = 'Home Page';

        return view('admin/pages/home', compact('title'));
    }
}
