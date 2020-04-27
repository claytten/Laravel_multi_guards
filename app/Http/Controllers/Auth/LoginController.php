<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customers\Requests\LoginRequest;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest',['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login the admin
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();
            
            if($user->is_active){
                if ($this->attemptLogin($request)) {
                    
                    return $this->sendLoginResponse($request);
                }
                
                $this->incrementLoginAttempts($request);
            } else {
                $this->incrementLoginAttempts($request);
                
                return redirect('/login')->with('message', 'Cannot Login, Please contact your administrator');
            }
        } else {
            return redirect('/login')->with('message', 'Cannot Login, Please contact your administrator');
        }
    }

    /**
     * Get the needed authorization credentials from the request
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request){
        $field = $this->field($request);

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password')
        ];
    }
    /**
     * Determine if the request field is email or username
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function field(Request $request){
        $email = $this->username();
        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }
    /**
     * Get the login username to be used by controller
     *
     * @return string
     */
    public function username(){
        return 'email';
    }
}
