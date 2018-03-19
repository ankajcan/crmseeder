@extends('emails/master_email')

@section('title')
    <title>Reset Password</title>
@endsection

@section('preheader')

@endsection

@section('content')
    <table class="main">
        <!-- START MAIN CONTENT AREA -->
        <tr>
            <td class="wrapper">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <p>Hello!</p>
                            <p>You are receiving this email because we received a password reset request for your account.</p>
                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td> <a href="{{ url(config('app.url').route('password.reset', $token, false)) }}" target="_blank">Reset Password</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <p>If you did not request a password reset, no further action is required.</p>
                            <p>Feelena</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- END MAIN CONTENT AREA -->
    </table>
@endsection

