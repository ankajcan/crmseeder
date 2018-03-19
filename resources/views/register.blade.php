@extends('master_front')
@section('content')
    <div class="container">

        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <div>
                    <h2 class="logo-name">CRM</h2>
                </div>
                <div class="col-xs-12">
                    <form id="sign-up-form">
                        {{ csrf_field() }}
                        <input id="on-success" type="hidden" name="on_success" value="">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6" data-error="first_name">
                                    <input type="text" class="form-control" required name="first_name" placeholder="First name">
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                                <div class="col-xs-12 col-sm-6" data-error="last_name">
                                    <input type="text" class="form-control" required name="last_name" placeholder="Last Name">
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12" data-error="email">
                                    <input type="email" class="form-control" required name="email" placeholder="Your Email">
                                    <p class="text-danger text-left error-content"></p>
                                </div>
                            </div>
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
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted text-center"><small>Already have an account?</small></p>
                        <a class="btn btn-sm btn-default btn-block" href="{{ route('login') }}">Sign In</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
@stop
