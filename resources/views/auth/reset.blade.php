@extends('admin.layouts.sb-wrapper')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Create a New Password</h3>
                </div>
                <div class="panel-body">
                    @include('admin._partials.alerts')
                    <form role="form" method="POST" action="{{ URL::route('auth.password.update', $token) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="token" value="{{ $token }}">

                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" value="{{ old('email') }}" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="New Password" name="password" type="password" value="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Confirm New Password" name="password_confirmation" type="password" value="">
                            </div>

                            <button class="btn btn-lg btn-success btn-block">Reset Password</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
