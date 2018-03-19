@extends('emails/master_email')

@section('title')
    <title>Email Confirmation</title>
@endsection

@section('preheader')
    {{--<span class="preheader">Thank you for using Brand.</span>--}}
@endsection

@section('content')
    <table class="main">
        <!-- START MAIN CONTENT AREA -->
        <tr>
            <td class="wrapper">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <p>Hello,</p>
                            <p>Thank you for using Brand. Please click on button bellow to confirm your email address.</p>
                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td> <a href="{{ route('confirmation',['code'=> $user->confirmation_code]) }}" target="_blank">Confirm Email</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <p>Best Regards</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- END MAIN CONTENT AREA -->
    </table>
@endsection

