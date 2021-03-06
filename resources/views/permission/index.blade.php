@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-10">
            <h2>Permissions</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="active">
                    <strong>Permissions</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 pos-rel">
            <a href="{{ route('permission.show', ['id' => 'new']) }}" type="button" class="btn btn-primary pull-right btn-new-entity">New Permission</a>
        </div>
    </div>
    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row m-b-md">
                </div>
                <div class="list-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Roles</th>
                                <th>Users</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($entities as $key => $entity)
                                <tr data-href="{{ route('permission.show', ['id' => $entity->id]) }}" class="clickable-row cursor-pointer entity-row">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $entity->name }}</td>
                                    <td>{{ count($entity->roles) }}</td>
                                    <td>{{ count($entity->users) }}</td>
                                    <td class="action">
                                        <a href="{{ route('permission.show', ['id' => $entity->id]) }}" class="btn btn-outline btn-sm btn-success">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
