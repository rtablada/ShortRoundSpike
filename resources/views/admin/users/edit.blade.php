@extends('admin.layouts.sb-wrapper')

@section('page')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>
                <div class="panel-body">
                    <form class="form" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="_method" value="PUT"/>

                        <fieldset>
                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : null}}">
                                <label for="name" class="control-label col-md-2 text-right">Name:</label>
                                <div class="col-md-8">
                                    <input name="name" id="name" class="form-control" type="text" value="{{ old('name', $user->name) }}"/>
                                    @if($errors->has('name'))
                                        <div class="help-block">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('email') ? 'has-error' : null}}">
                                <label for="email" class="control-label col-md-2 text-right">Email:</label>
                                <div class="col-md-8">
                                    <input name="email" id="email" class="form-control" type="text" value="{{ old('email', $user->email) }}"/>
                                    @if($errors->has('email'))
                                        <div class="help-block">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="actions pull-right">
                                        <a class="btn btn-default" href="{{ URL::route('admin.users.index') }}">Back</a>
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.data-table')
