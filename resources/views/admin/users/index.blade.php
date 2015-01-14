@extends('admin.layouts.sb-wrapper')

@section('page')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 index-actions">
                            <a class="btn btn-primary pull-right" href="{{ route('admin.users.create') }}">Create User <i class="fa fa-plus fa-lg"></i></a>
                        </div>
                    </div>

                    <table id="data-table" class="table table-striped table-bordered table-hover data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><a href="{{ URL::route('admin.users.edit', $user) }}"><i class="fa fa-edit fa-lg"></i></a></td>
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
