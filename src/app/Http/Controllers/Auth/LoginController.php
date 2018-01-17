<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Log;

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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        Log::debug("login start");
        $this->validateLogin($request);
        Log::debug("login validated");
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            Log::debug("login too many attempts");
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        Log::debug("login attempts accepted");
        if ($this->attemptLogin($request)) {
            Log::debug("login attempt success");
            return $this->sendLoginResponse($request);
        }
        Log::debug("login attempt failed");
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        Log::debug('validateLogin()');
        $this->validate($request, [
            $this->username() => 'required|string',
            'legacy_password' => 'required|string',
        ]);
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Log::debug('logout()');
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/static/discounts';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::debug('__construct()');
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        Log::debug('username()');
        return 'legacy_username';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        Log::debug('credentials()');
        return $request->only($this->username(), 'legacy_password');
    }

}
