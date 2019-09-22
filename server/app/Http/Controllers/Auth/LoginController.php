<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserImpersonnation;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        return config('app.admin_path');
    }

    /**
     * Log the user out of the application.
     *
     * @throws \RuntimeException
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        app(UserImpersonnation::class)->logout();

        return redirect($this->redirectTo());
    }
}
