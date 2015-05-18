<?php  namespace App\Http\Controllers\Auth;


use App\Gateways\DbUserGateway;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    use ValidatesRequests;

    protected $validationMessage = 'These credentials do not match our records.';

    protected $rules = [
        'email' => 'required|email',
    ];
    /**
     * @var \App\Gateways\DbUserGateway
     */
    protected $user;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Gateways\DbUserGateway $user
     */
    public function __construct(Request $request, DbUserGateway $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.password');
    }

    /**
     * Handle a login request to the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate($this->request);

        if ($this->user->emailPasswordReset($this->request->get('email'))) {
            return redirect()->route('auth.session.create')
                ->with('success', 'Your password reset email has been sent!');
        }

        return redirect()->back()
            ->with('danger', 'These credentials do not match our records.')
            ->withInput($this->request->only('email'));
    }

    public function edit($token)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.reset')
            ->with('token', $token);
    }

    public function update($token)
    {
        $this->validationMessage = 'There was an error resetting your password.';
        $this->validate($this->request, [
            'token'    => 'required',
            'email'    => 'required',
            'password' => 'required|confirmed',
        ]);

        $credentials = $this->request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->user->resetPassword($credentials);

        if ($response === true) {
            return redirect()->route('auth.session.create')
                ->with('success', 'You have reset your password. Please login.');
        } else {

            return redirect()->back()
                ->withInput($this->request->only('email'))
                ->with('danger', trans($response));
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
            ->with('danger', $this->validationMessage)
            ->withErrors($errors);
    }
}
