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

    /**
     * Redirect after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Redirect after logout.
     *
     * @var string
     */
    protected $redirectAfterLogout = '/login';

    /**
     * Guard table name.
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * Get login view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Login action.
     *
     * @param LoginRequest $request
     * @param Guard $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(LoginRequest $request, Guard $auth)
    {
        $input = $request->all();

        // Filter login with email or name.
        $logAccess = filter_var($input['log'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Throttle
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

            return response()->json(['return' => false, 'value' => 'Login failed, One more try.']);
        }

        $user = $auth->getLastAttempted();

        if ($user) {
            if ($throttle) {
                $this->clearLoginAttempts($request);
            }

            $auth->login($user, $input['remember']);

            session()->put('user_name', $user->name);
            session()->put('user_email', $user->email);

            return response()->json(['return' => true, 'value' => url('/dashboard')]);
        }
        return response()->json(['return' => false, 'value' => 'Login failed, One more try.']);
    }
}
