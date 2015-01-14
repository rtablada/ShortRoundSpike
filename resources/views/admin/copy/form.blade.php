@extends('admin.layouts.sb-wrapper')

@section('page')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>
                <div class="panel-body">
                    <form class="form" action="{{ $route }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        @if ($method)
                            <input type="hidden" name="_method" value="{{ $method }}"/>
                        @endif

                        <fieldset>
                            @if ($new)
                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : null}}">
                                    <label for="name" class="control-label col-md-2 text-right">Name:</label>
                                    <div class="col-md-8">
                                        <input name="name" id="name" class="form-control" type="text" value="{{ old('name', $copy->name) }}"/>
                                        @if($errors->has('name'))
                                            <div class="help-block">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row {{ $errors->has('value') ? 'has-error' : null}}">
                                <label for="value" class="control-label col-md-2 text-right">Copy:</label>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="editable form-control" data-field="value"><?= old('value', $copy->value) ?></div>
                                    <input type="hidden" name="value" class="form-control"></input>

                                    @if($errors->has('value'))
                                        <div class="help-block">{{ $errors->first('value') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="actions pull-right">
                                        <a class="btn btn-default" href="{{ URL::route('admin.copy.index') }}">Back</a>
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

@include('admin._partials.medium-editor')
