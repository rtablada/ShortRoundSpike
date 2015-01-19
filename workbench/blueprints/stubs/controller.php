<?php  namespace App\Http\Controllers\Admin;

use App\Gateways\DbRoleGateway;
use App\Gateways\Db{{ modelUpper }}Gateway;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class {{ modelUpperPlural }}Controller extends AdminController
{
    use ValidatesRequests;

    protected $viewNamespace = 'admin.{{ dashedPlural }}';

    protected $defaultTitle = '{{ modelUpperPlural }}';

    protected ${{ modelVar }};

    protected $request;

    protected $rules = [
    ];

    protected $storeRules = [
    ];

    public function __construct(Db{{ modelUpper }}Gateway ${{ modelVar }}, Request $request)
    {
        $this->{{ modelVar }} = ${{ modelVar }};
        $this->request = $request;
    }

    public function index()
    {
        ${{ modelPlural }} = $this->{{ modelVar }}->all();

        return $this->render('index', compact('{{ modelPlural }}'));
    }

    public function create()
    {
        ${{ modelVar }} = $this->{{ modelVar }}->newInstance();

        return $this->{{ modelVar }}Form('create', ${{ modelVar }}, 'New {{ modelUpper }}');
    }

    public function store()
    {
        $this->validate($this->request, $this->storeRules);

        ${{ modelVar }} = $this->{{ modelVar }}->create($this->request->all());

        return redirect()->route('admin.{{ dashedPlural }}.index')
            ->with('success', '{{ modelUpper }} updated successfully.');
    }

    public function edit($id)
    {
        ${{ modelVar }} = $this->{{ modelVar }}->find($id);

        return $this->{{ modelVar }}Form('edit', ${{ modelVar }});
    }

    public function profile()
    {
        return $this->{{ modelVar }}Form('edit', $this->guard->{{ modelVar }}());
    }

    public function {{ modelVar }}Form($action, ${{ modelVar }}, $title = null)
    {
        $title = $title ?: 'Editing {{ modelUpper }} - ' . ${{ modelVar }}->id;

        switch ($action) {
            case 'create':
                $method = null;
                $route = route('admin.{{ dashedPlural }}.store');
                break;
            case 'edit':
                $method = 'put';
                $route = route('admin.{{ dashedPlural }}.update', ${{ modelVar }});
        }

        return $this->render('form', compact('{{ modelVar }}', 'method', 'route'), $title);
    }

    public function update($id)
    {
        $this->validate($this->request);

        ${{ modelVar }} = $this->{{ modelVar }}->update($id, $this->request->all());

        if (${{ modelVar }}) {
            return redirect()->route('admin.{{ dashedPlural }}.index')
                ->with('success', '{{ modelUpper }} updated successfully.');
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

    public function up($id)
    {
        $this->{{ modelVar }}->moveHigher($id);

        return redirect()->back()
            ->withSuccess('Item moved!');
    }

    public function down($id)
    {
        $this->{{ modelVar }}->moveLower($id);

        return redirect()->back()
            ->withSuccess('Item moved!');
    }
}
