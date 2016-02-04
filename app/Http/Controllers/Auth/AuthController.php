<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/dashboard';

    protected $guard = 'admin';

    public function loginView()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request, Guard $auth)
    {
        $input = $request->all();
        $logAccess = filter_var($input['log'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $throttle = in_array(ThrottlesLogins::class, class_uses_recursive(get_class($this)));

        if ($throttle && $this->hasTooManyLoginAttempts($request)) {
            return response()->json(['return' => false, 'value' => 'Too many attempts.']);
        }

        $credentials = [
            $logAccess => $input['log'],
            'password' => $input['password']
        ];

        if (!$auth->validate($credentials)) {
            if ($throttle) {
                $this->incrementLoginAttempts($request);
            }

            return response()->json(['return' => false, 'value' => 'Login failed, One more try1.']);
        }

        $user = $auth->getLastAttempted();

        if ($user) {
            if ($throttle) {
                $this->clearLoginAttempts($request);
            }

            $auth->login($user, $input['remember']);

            if ($request->session()->has('user_id')) {
                $request->session()->forget('user_id');
            }

            return response()->json(['return' => true, 'value' => url('/dashboard')]);
        }

        $request->session()->put('user_id', $user->id);

        return response()->json(['return' => false, 'value' => 'Login failed, One more try.']);


    }

}
