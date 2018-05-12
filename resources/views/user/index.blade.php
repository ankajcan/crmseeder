@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-8">
            <h2>Users</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="active">
                    <strong>Users</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-4 pos-rel">
            <div class="row action-btn-container">
                <div class="col-xs-12">
                    <a href="{{ route('user.show', ['id' => 'new']) }}" type="button" class="btn btn-primary pull-right">New User</a>

                    <a href="{{ route('user.invite') }}" type="button" class="btn btn-success pull-right m-r-md">Invite User</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row m-b-md">
                        <div class="col-xs-6">
                            <form id="search-form">
                                <input type="hidden" name="page" />
                                <input type="hidden" name="sort" />
                                <input type="hidden" name="order" />
                                <input type="text" placeholder="Search" name="search" class="input-sm form-control" />
                            </form>
                        </div>
                        <div class="col-xs-6">

                        </div>
                    </div>
                    <div class="list-container">
                        @include('user/list')
                    </div>
                </div>
            </div>
    </div>
@stop
