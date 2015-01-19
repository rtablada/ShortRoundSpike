<?php  namespace App\Http\Controllers\Admin;

use App\Gateways\DbRoleGateway;
use App\Gateways\DbEmployeeGateway;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class EmployeesController extends AdminController
{
    use ValidatesRequests;

    protected $viewNamespace = 'admin.employees';

    protected $defaultTitle = 'Employees';

    protected $employee;

    protected $request;

    protected $rules = [
    ];

    protected $storeRules = [
    ];

    public function __construct(DbEmployeeGateway $employee, Request $request)
    {
        $this->employee = $employee;
        $this->request = $request;
    }

    public function index()
    {
        $employees = $this->employee->all();

        return $this->render('index', compact('employees'));
    }

    public function create()
    {
        $employee = $this->employee->newInstance();

        return $this->employeeForm('create', $employee, 'New Employee');
    }

    public function store()
    {
        $this->validate($this->request, $this->storeRules);

        $employee = $this->employee->create($this->request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function edit($id)
    {
        $employee = $this->employee->find($id);

        return $this->employeeForm('edit', $employee);
    }

    public function profile()
    {
        return $this->employeeForm('edit', $this->guard->employee());
    }

    public function employeeForm($action, $employee, $title = null)
    {
        $title = $title ?: 'Editing Employee - ' . $employee->id;

        switch ($action) {
            case 'create':
                $method = null;
                $route = route('admin.employees.store');
                break;
            case 'edit':
                $method = 'put';
                $route = route('admin.employees.update', $employee);
        }

        return $this->render('form', compact('employee', 'method', 'route'), $title);
    }

    public function update($id)
    {
        $this->validate($this->request);

        $employee = $this->employee->update($id, $this->request->all());

        if ($employee) {
            return redirect()->route('admin.employees.index')
                ->with('success', 'Employee updated successfully.');
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
        $this->employee->moveHigher($id);

        return redirect()->back()
            ->withSuccess('Item moved!');
    }

    public function down($id)
    {
        $this->employee->moveLower($id);

        return redirect()->back()
            ->withSuccess('Item moved!');
    }
}
