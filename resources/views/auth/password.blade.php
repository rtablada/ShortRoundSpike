@extends('admin.layouts.sb-wrapper')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Request Password Reset</h3>
                </div>
                <div class="panel-body">
                    @include('admin._partials.alerts')
                    <form role="form" method="POST" action="{{ URL::route('auth.password.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" value="{{ old('email') }}" autofocus>
                                <div class="help-block">
                                    <a href="{{ URL::route('auth.session.create') }}">Login</a>
                                </div>
                            </div>
                            <button class="btn btn-lg btn-success btn-block">Send Password Reset Link</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
