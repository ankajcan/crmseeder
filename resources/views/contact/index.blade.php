@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-8">
            <h2>Contacts</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="active">
                    <strong>Contacts</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-4 pos-rel">
            <div class="row action-btn-container">
                <a href="{{ route('contact.show', ['id' => 'new']) }}" type="button" class="btn btn-primary pull-right btn-new-entity">New Contact</a>
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
                            <div class="checkbox-action pull-right hidden">
                                <span class="bg-muted p-xxs b-r-sm"><span class="selected-entities">0</span> selected</span>
                                <a id="btn-entities-delete" class="btn btn-sm btn-white m-b-none-i"><i class="fa fa-trash"></i> Delete </a>
                            </div>
                        </div>
                    </div>
                    <div class="list-container">
                        @include('contact/list')
                    </div>
                </div>
            </div>
    </div>
@stop
