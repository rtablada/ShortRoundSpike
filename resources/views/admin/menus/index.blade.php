@extends('admin.layouts.sb-wrapper')

@section('page')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered table-hover data-table">
                        <thead>
                            <tr>
                                <th>Menu Name</th>
                                <th>Base URL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->base_url }}</td>
                                <td><a href="{{ URL::route('admin.menus.show', $menu->slug) }}"><i class="fa fa-edit fa-lg"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.data-table')
