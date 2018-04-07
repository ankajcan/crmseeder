@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading list-page-header">
        <div class="col-lg-10">
            <h2>
                @if($entity->id)
                    <h2>Contact #{{ $entity->id }}</h2>
                @else
                    <h2>New Contact</h2>
                @endif
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('contact.index') }}">Contacts</a>
                </li>
                <li class="active">
                    <strong>
                        @if($entity->id)
                            {{ $entity->full_name }}
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
                            {{-- BASIC INFO --}}
                            @if($entity->id)
                                <div class="form-group">
                                    <label class="col-sm-1 form-control-static">ID</label>
                                    <div class="col-sm-2">
                                        <p class="form-control-static"> {{ $entity->id }}</p>
                                        <input type="hidden" name="id" value="{{ $entity->id }}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-1 form-control-static">Created</label>
                                    <div class="col-sm-3">
                                        <p class="form-control-static">
                                            {{ Carbon\Carbon::parse($entity->created_at)->format('m/d/Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group" data-error="type">
                                <label class="col-xs-12 col-sm-1 form-control-static">Type</label>
                                <div class="col-sm-2 col-xs-12">
                                    <select class="form-control" name="type" required>
                                        <option value="{{ \App\Models\Contact::TYPE_PERSON }}" @if($entity->type == \App\Models\Contact::TYPE_PERSON) selected @endif>Person</option>
                                        <option value="{{ \App\Models\Contact::TYPE_ORGANISATION }}" @if($entity->type == \App\Models\Contact::TYPE_ORGANISATION) selected @endif>Organisation</option>
                                    </select>
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group person-name-container @if($entity->type == \App\Models\Contact::TYPE_ORGANISATION) hidden @endif">
                                <div class="col-sm-3" data-error="first_name">
                                    <label>First name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="First name"
                                           @if($entity->type == \App\Models\Contact::TYPE_PERSON) required @endif value="{{ $entity->first_name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                                <div class="col-sm-3" data-error="last_name">
                                    <label>Last name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ $entity->last_name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group organisation-name-container @if($entity->type == \App\Models\Contact::TYPE_PERSON) hidden @endif">
                                <div class="col-sm-3" data-error="name">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                           @if($entity->type == \App\Models\Contact::TYPE_ORGANISATION) required @endif value="{{ $entity->name }}" />
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                            <div class="form-group" data-error="email">
                                <div class="col-sm-6">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $entity->email }}" />
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
                            <hr>
                            {{-- ADDRESS --}}
                                @if($entity->address)
                                    <input type="hidden" name="address.id" value="{{ $entity->address->id }}" />
                                @endif
                                <div class="form-group">
                                    <div class="col-sm-4">
                                            <label>Address</label>
                                            <input type="text" name="address.address" class="form-control"
                                                   value="{{ $entity->address ? $entity->address->address : '' }}" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Apt / Unit</label>
                                        <input type="text" name="address.apt" class="form-control"
                                        value="{{ $entity->address ? $entity->address->apt : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label>City</label>
                                        <input type="text" name="address.city" class="form-control"
                                               value="{{ $entity->address ? $entity->address->city : '' }}" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>State</label>
                                        <input type="text" name="address.state" class="form-control"
                                               value="{{ $entity->address ? $entity->address->state : '' }}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label>ZIP</label>
                                        <input type="text" name="address.zip" class="form-control"
                                               value="{{ $entity->address ? $entity->address->zip : '' }}" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Country</label>
                                        <select class="form-control" name="address.country_id">
                                            <option value=""></option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        @if($entity->address) @if($country->id == $entity->address->country_id) selected @endif  @endif>
                                                    {{$country->name}}
                                                </option>
                                            @endforeach
                                        </select>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
