@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-10">
            <h2>
                @if($entity->id)
                    <h2>User #{{ $entity->id }}</h2>
                @else
                    <h2>New User</h2>
                @endif
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}">Users</a>
                </li>
                <li class="active">
                    <strong>
                        @if($entity->id)
                            {{ $entity->first_name }} {{ $entity->last_name }}
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
                        <div class="m-b-md">

                        </div>
                        <form id="update-entity" class="form-horizontal">
                            @if($entity->id)
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ID</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $entity->id }}</p>
                                        <input type="hidden" name="id" value="{{ $entity->id }}" >
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-3" data-error="first_name">
                                    <input type="text" name="first_name" class="form-control" placeholder="First name" required value="{{ $entity->first_name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                                <div class="col-sm-3" data-error="last_name">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last name" required value="{{ $entity->last_name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group" data-error="email">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ $entity->email }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            @if(!$entity->id)
                                <div class="form-group" data-error="password">
                                    <label class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" required  name="password" placeholder="Choose a Password">
                                        <p class="text-danger text-left error-content"></p>
                                    </div>
                                </div>
                                <div class="form-group" data-error="password_confirm">
                                    <label class="col-sm-2 control-label">Password repeat</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" required  name="password_confirm" placeholder="Repeat Password">
                                        <p class="text-danger text-left error-content"></p>
                                    </div>
                                </div>
                            @endif
                            @if($entity->id)
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Created</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ Carbon\Carbon::parse($entity->created_at)->format('m/d/Y') }}</p>

                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Roles</label>
                                <div class="col-sm-10">
                                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                        <label class="checkbox-inline">
                                            <input name="roles[]" type="checkbox" @if($entity->hasRole($role->name)) checked @endif value="{{ $role->name }}" id=""> {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Avatar</label>
                                <div class="col-sm-10">
                                    @if($entity->avatar)
                                        <img id="img-entity-avatar" src="{{ $entity->avatar->url }}" class="img-lg"> <br> <br>
                                    @else
                                        <img id="img-entity-avatar" src="http://via.placeholder.com/200x200?text=Avatar" class="img-lg"> <br> <br>
                                    @endif
                                    <a id="btn-avatar-upload" class="btn btn-success" @click="openUploadDialog"> Upload Photo</a>
                                    <input type="hidden" id="input-entity-avatar" name="avatar" value="" >
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-8">
                                    @if($entity->id)
                                        <a id="btn-delete-entity" data-entity-id="{{ $entity->id }}" class="btn btn-danger pull-left">Delete</a>
                                    @endif
                                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                                </div>
                            </div>
                        </form>
                        <form class="hidden" enctype="multipart/form-data">
                            <input id="input-avatar-upload" type="file" name="file" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
