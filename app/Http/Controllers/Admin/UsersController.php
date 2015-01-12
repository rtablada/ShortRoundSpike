<?php  namespace App\Http\Controllers\Admin;

use App\Gateways\DbUserGateway;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class UsersController extends AdminController
{
    use ValidatesRequests;

    protected $viewNamespace = 'admin.users';

    protected $defaultTitle = 'Users';

    /**
     * @var \App\Gateways\DbUserGateway
     */
    protected $user;
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    protected $rules = [
        'email' => 'required|email',
    ];

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $guard;

    public function __construct(DbUserGateway $user, Request $request, Guard $guard)
    {
        $this->user = $user;
        $this->request = $request;
        $this->guard = $guard;
    }

    public function index()
    {
        $users = $this->user->all();

        return $this->render('index', compact('users'));
    }

    public function edit($id)
    {
        $user = $this->user->find($id);

        return $this->userForm($user);
    }

    public function profile()
    {
        return $this->userForm($this->guard->user());
    }

    public function userForm($user, $title = null)
    {
        $title = $title ?: 'Editing User - ' . $user->name;

        return $this->render('edit', compact('user'), $title);
    }

    public function update($id)
    {
        $this->validate($this->request);

        $this->user->update($id, $this->request->only('email', 'name'));

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @return void
     */
    public function validate(Request $request, array $rules = null)
    {
        $rules = $rules ?: $this->rules;

        $validator = $this->getValidationFactory()->make($request->all(), $rules);

        if ($validator->fails())
        {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->ajax())
        {
            return new JsonResponse($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->input())
            ->with('danger', 'The information you entered was not valid.')
            ->withErrors($errors);
    }
}
