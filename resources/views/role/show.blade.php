@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-10">
            <h2>
                @if($entity->id)
                    <h2>Role #{{ $entity->id }}</h2>
                @else
                    <h2>New Role</h2>
                @endif
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('role.index') }}">Roles</a>
                </li>
                <li class="active">
                    <strong>
                        @if($entity->id)
                            {{ $entity->name }}
                        @else
                            New
                        @endif
                    </strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 pos-rel">
        </div>
    </div>
    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="update-entity" class="form-horizontal">
                            @if($entity->id)
                                <input type="hidden" name="id" value="{{ $entity->id }}" >
                                <div class="form-group">
                                    <label class="col-sm-1 form-control-static">ID</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $entity->id }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="col-sm-6" data-error="name">
                                    <label class="">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Role name" required value="{{ $entity->name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="">Permissions</label>
                                    @foreach($permissions as $permission)
                                        <div class="checkbox">
                                            <input id="permission-{{ $permission->id }}" @if($entity->hasPermissionTo($permission->name)) checked @endif name="permissions[]" value="{{ $permission->name }}" type="checkbox">
                                            <label for="permission-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-8">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    @if($entity->id)
                                        <a id="btn-delete-entity" data-entity-id="{{ $entity->id }}" class="btn btn-danger btn-outline">Delete</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
