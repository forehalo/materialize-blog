<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $input = $request->all();

        // Filter login with email or name.
        $logAccess = filter_var($input['log'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

//        if ($this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//            $seconds = $this->limiter()->availableIn(
//                $this->throttleKey($request)
//            );
//            return response()->json([
//                'status' => 0,
//                'message' => "Too many attempts. Try after $seconds seconds."
//            ]);
//        }

        $credentials = [
            $logAccess => $input['log'],
            'password' => $input['password']
        ];

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            $this->clearLoginAttempts($request);
            $request->session()->regenerate();
            return response()->json(['status' => 1, 'redirect' => url('/dashboard')]);
        }

//        $this->incrementLoginAttempts($request);
        return response()->json(['status' => 0, 'message' => 'Login failed, One more try.']);
    }
}
