@extends('admin.layouts.sb-wrapper')

@section('page')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>
                <div class="panel-body">
                    <form class="form" action="{{ URL::route('admin.site-settings.store') }}" method="POST">

                        <input type="hidden" name="_token" value="{{ Session::token() }}"/>

                        @foreach($settings as $setting)
                            <div class="form-group row {{ $errors->has($setting->slug) ? 'has-error' : null}}">
                                <label for="{{ $setting->slug }}" class="control-label col-md-2 text-right">{{ $setting->name }}:</label>
                                <div class="col-md-8">
                                    <input name="{{ $setting->slug }}" id="{{ $setting->slug }}" class="form-control" type="text" value="{{ Input::old($setting->slug, $setting->value) }}"/>
                                </div>
                            </div>
                        @endforeach

                        <div class="row">
                            <div class="col-md-10">
                                <div class="actions pull-right">
                                    <a class="btn btn-default" href="{{ URL::route('admin.site-settings.edit') }}">Reset Values</a>
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.data-table')
