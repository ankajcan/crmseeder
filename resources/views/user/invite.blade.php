@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-10">
            <h2>
                Invite User
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
                        New
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
                        <form id="invite-entity" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3" data-error="first_name">
                                    <label class="">First name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="First name" required value="{{ $entity->first_name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                                <div class="col-sm-3" data-error="last_name">
                                    <label class="">Last name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last name" required value="{{ $entity->last_name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group" data-error="email">
                                <div class="col-sm-6">
                                    <label class="">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ $entity->email }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <label class="">Roles</label><br>
                                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                        <div class="checkbox checkbox-inline">
                                            <input id="role-{{ $role->id }}" name="roles[]" type="checkbox" @if($entity->hasRole($role->name)) checked @endif value="{{ $role->name }}" id="">
                                            <label for="role-{{ $role->id }}"> {{ $role->name }} </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-8">
                                    <button type="submit" class="btn btn-primary">Invite</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
