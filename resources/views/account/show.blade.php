@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-10">
            <h2>
                Account
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="active">
                    <strong>
                        Account
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
                            <input type="hidden" name="id" value="{{ $entity->id }}" >
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6">
                                    <label class="">Avatar</label>
                                    <div id="avatar-container">
                                        @include('account/avatar', ['avatar' => $entity->avatar])
                                    </div>
                                </div>
                            </div>
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
                                <div class="col-sm-6 col-xs-12">
                                    <label class="">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ $entity->email }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group" data-error="phone">
                                <div class="col-sm-6">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ $entity->phone }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div class="col-sm-6">
                                    <label>Password</label><br>
                                    <a href="{{ route('password.request') }}">Change password</a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
