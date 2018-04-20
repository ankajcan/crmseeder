@extends('master_front')
@section('content')
    <div class="container">

        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <div>
                    <h2 class="logo-name">CRM</h2>
                </div>
                <div class="col-xs-12">
                    <form id="invitation-form" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" required name="invitation" value="{{ $entity->invitation }}">
                        <div class="form-group">
                            <input type="email" class="form-control" required disabled name="email" value="{{ $entity->email }}"  placeholder="Email">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12" data-error="password">
                                    <input type="password" class="form-control" required  name="password" placeholder="Choose a Password">
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12" data-error="password_confirm">
                                    <input type="password" class="form-control" required  name="password_confirm" placeholder="Repeat Password">
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" data-error="message">
                            <p class="text-danger center error-content"></p>
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Join</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@stop
