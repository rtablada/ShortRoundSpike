<?php  namespace App\Http\Controllers\Admin;

use App\Gateways\DbCopyGateway;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class CopyController extends AdminController
{
    use ValidatesRequests;

    protected $viewNamespace = 'admin.copy';

    protected $defaultTitle = 'Copy';

    /**
     * @var \App\Gateways\DbCopyGateway
     */
    protected $copy;
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    protected $rules = [
        'value' => 'required',
    ];

    protected $storeRules = [
        'name' => 'required',
    ];

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $guard;

    public function __construct(DbCopyGateway $copy, Request $request, Guard $guard)
    {
        $this->copy = $copy;
        $this->request = $request;
        $this->guard = $guard;
    }

    public function index()
    {
        $copyCollection = $this->copy->all();

        return $this->render('index', compact('copyCollection'));
    }

    public function create()
    {
        $copy = $this->copy->newInstance();

        return $this->renderForm('create', $copy, 'New Copy');
    }

    public function store()
    {
        $this->validate($this->request, $this->storeRules);

        $this->copy->create($this->request->only('value', 'name'));

        return redirect()->route('admin.copy.index')
            ->with('success', 'Copy created successfully.');
    }

    public function edit($id)
    {
        $copy = $this->copy->forSlug($id);

        return $this->renderForm('edit', $copy);
    }

    public function renderForm($action, $copy, $title = null)
    {
        $title = $title ?: 'Editing - ' . $copy->name;
        $new = false;

        switch ($action) {
            case 'create':
                $new = true;
                $method = null;
                $route = route('admin.copy.store');
                break;
            case 'edit':
                $method = 'put';
                $route = route('admin.copy.update', $copy->slug);
        }

        return $this->render('form', compact('copy', 'method', 'route', 'new'), $title);
    }

    public function update($id)
    {
        $this->validate($this->request);

        $response = $this->copy->updateForSlug($id, $this->request->only('value'));

        if ($response) {
            return redirect()->route('admin.copy.index')
                ->with('success', 'Copy updated successfully.');
        }
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $rules
     * @return void
     */
    public function validate(Request $request, array $rules = null)
    {
        $rules = $rules ?: $this->rules;

        $validator = $this->getValidationFactory()->make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->ajax()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->input())
            ->with('danger', 'The information you entered was not valid.')
            ->withErrors($errors);
    }
}
