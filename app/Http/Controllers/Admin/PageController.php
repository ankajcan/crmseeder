<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Transaction;
use App\Models\User;
use Boxt\Services\Payments\PaymentGateway;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PageController extends Controller
{

    public function dashboard(Request $request)
    {
        return view('admin/dashboard_admin');
    }

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    public function users(Request $request)
    {
        $users = User::all();

        return view('admin/users', ["users" => $users]);
    }

    public function user(Request $request, $id)
    {
        $user = $id == "new" ? new User() : User::find($id);

        return view('admin/user', ["user" => $user]);
    }

}
