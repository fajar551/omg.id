<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    const TOKEN_NAME = "authweb-token";
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
    protected $redirectTo = RouteServiceProvider::HOME_ADMIN;

    protected $logName  = 'auth.admin.log';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function logout(Request $request)
    {
        self::revokeToken();
        
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route('admin.login')->with(['type' => 'success', 'message' => __('page.logout_success')]);
    }

    protected function sendFailedLoginResponse(Request $request) {
        /*
        activity()
            ->inLog($this->logName)
            ->withProperties(['ip_address' => request()->ip(), 'browser_info' => \Utils::browserInfo()])
            ->log($request->input($this->username()) ." failed to login: " .trans('auth.failed'));
        */

        return redirect()->back()
                ->withInput()
                ->with(['type' => 'danger', 'message' => __('page.login_failed')])
                ->withErrors(['identity' => [trans('auth.failed')]]);
    }

    public function username() {
        $login = request()->input('identity');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);

        return $field;
    }

    protected function credentials(Request $request) {
        return [$this->username() => $request->identity, 'password' => $request->password, /*'is_active' => 1*/];
    }

    protected function authenticated(Request $request, $user) {
        /*
        activity()
            ->inLog($this->logName)
            ->withProperties(['ip_address' => request()->ip(), 'browser_info' => \Utils::browserInfo()])
            ->log("$user->email logged in");
        */

        // $tokens = $user->tokens()->get();
        // foreach ($tokens as $token) {
        //     if (session()->has($token->name)) {
        //         $token->where("name", $token->name)->delete();
        //     }
        // }

        if ($user->hasRole(['creator'])) {
            $this->guard()->logout();
            $request->session()->invalidate();
    
            return $this->sendFailedLoginResponse($request);
        }
        
        $token = $user->createToken($sessionTokenName = self::TOKEN_NAME ."-" .session()->getId())->plainTextToken;
        session(['access_token' => $token]);
    }

    public static function revokeToken()
    {
        $token = Auth::user()->tokens()->where("name", self::TOKEN_NAME ."-" .session()->getId());
        if ($token) { 
            $token->delete(); 
        }
    }

}
