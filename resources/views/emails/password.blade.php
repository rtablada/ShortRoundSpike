@if (isset($message->newUser) && $message->newUser)
    <h1>Welcome New user!</h1>
@endif

<p>Click here to reset your password: {{ route('auth.password.edit', $token) }}</p>

