<?php  namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    use ValidatesRequests;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $auth;

    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required',
    ];

    public function __construct(Request $request, Guard $auth)
    {
        $this->request = $request;
        $this->auth = $auth;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate($this->request);

        $credentials = $this->request->only('email', 'password');

        if ($this->auth->attempt($credentials, $this->request->has('remember'))) {

            return redirect()->intended(route('admin.dashboard.index'))
                ->with('success', 'You have logged in.');
        }


        return redirect()->route('auth.session.create')
            ->with('danger', 'These credentials do not match our records.')
            ->withInput($this->request->only('email'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $this->auth->logout();

        return redirect()->route('auth.session.create')
            ->with('success', 'You have logged out.');
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
            ->with('danger', 'These credentials do not match our records.')
            ->withErrors($errors);
    }
}
