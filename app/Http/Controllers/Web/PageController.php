<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Boxt\Services\Payments\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | FRONT
    |--------------------------------------------------------------------------
    */

    public function home(Request $request)
    {
        if(Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function login(Request $request)
    {
        return view('login');
    }

    public function register(Request $request)
    {
        return view('register');
    }

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

}
