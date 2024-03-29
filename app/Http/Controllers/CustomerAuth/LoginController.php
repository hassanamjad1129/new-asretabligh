<?php

namespace App\Http\Controllers\CustomerAuth;

use App\Http\Controllers\Controller;
use App\Jobs\sendWelcomeSMSJob;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;


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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/customer/orders';


    public function redirectTo()
    {

        if (request()->has('previous')) {
            $this->redirectTo = request()->get('previous');
        }

        return $this->redirectTo ?? '/customer/orders';
    }


    protected function authenticated(Request $request, $user)
    {
        dispatch(new sendWelcomeSMSJob($user->phone));
        return redirect($this->redirectTo());
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

}
