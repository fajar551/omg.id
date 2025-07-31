<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use Socialite;
use Str;
use App\Models\User;
use App\Src\Exceptions\AuthorizationException;
use App\Src\Exceptions\ClientException;
use App\Src\Exceptions\ServerException;
use App\Src\Helpers\Utils;
use App\Src\Services\Auth\AuthService;
use App\Src\Services\Eloquent\ContentSubscribeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $logName  = 'auth.log';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Utils::wherePreviousRouteNameIn(['creator.contentdetail', 'creator.index', 'creator.content', 'creator.savedcontent'])) {
            session(['url.intended' => url()->previous()]);
            // $this->redirectTo = session()->get('url.intended');
        }

        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $userSocial = null;

            switch ($provider) {
                case 'facebook':
                case 'google':
                    $userSocial = Socialite::driver($provider)->stateless()->user();
                    break;
                case 'twitter':
                    $userSocial = Socialite::driver($provider)->user();
                    break;                
                default:
                    throw new InvalidArgumentException("Unknown Provider!");
                break;
            }

            if (!$userSocial) {
                throw new AuthorizationException("Authentication vailed! We can't get any information from your social account.", []);
            }

            if (!$userSocial->getEmail()) {
                throw new AuthorizationException("Authentication vailed! The email address is required to authenticated your account.", []);
            }

            $user = User::where(['email' => $userSocial->getEmail()])->first();

            if ($user) {
                Auth::login($user);
            } else {
                $authService = AuthService::getInstance();
                $data = [
                    'username' => $username = Str::lower(Str::random(8)),
                    'name' => $userSocial->getName(),
                    'email' => $userSocial->getEmail(),
                    'password' => $pwd = Str::random(8),
                    'password_confirmation' => $pwd,
                    'must_change_password' => 1,
                    'provider_id' => $userSocial->getId(),
                    'provider' => $provider,
                ];
    
                $user = $authService->register($data, false);
                $user = $user["user_model"];

                // Need send email verification for some profider because there's a case
                // that the user email for that provider maybe has no longer active e.g facebook
                if (in_array($provider, ["facebook", "twitter"])) {
                    event(new Registered($user));
                } else {
                    if ($user->markEmailAsVerified()) {
                        event(new Verified($user));
                    } else {
                        event(new Registered($user));
                    }
                }
    
                Auth::login($user);
            }

            $this->authenticated(request(), $user);
    
            return redirect()->intended($this->redirectPath());
        } catch (\Exception $ex) {
            $errors = [];
            $message = $ex->getMessage();

            if ($ex instanceof ClientException || $ex instanceof ServerException) {
                $errors = $ex->getErrors();
            }

            return redirect()
                    ->route('login')
                    ->withInput()
                    ->with(['type' => 'danger', 'message' => 'Login failed. Something went wrong. Please try again latter or use another account. <br>' .(config('app.debug') ? $message : '')])
                    ->withErrors($errors);
        }
    }

    public function logout(Request $request)
    {
        self::revokeToken();
        
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login')->with(['type' => 'success', 'message' => __('page.logout_success')]);
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

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            // 'g-recaptcha-response' => 'recaptcha',
        ]);
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
    
        if ($user->hasRole(['admin'])) {
            $this->guard()->logout();
            $request->session()->invalidate();
    
            return $this->sendFailedLoginResponse($request);
        }
        
        $token = $user->createToken($sessionTokenName = self::TOKEN_NAME ."-" .session()->getId())->plainTextToken;
        session(['access_token' => $token]);
        ContentSubscribeService::getInstance()->checkEmailGuest($user->email, $user->id);
    }

    public static function revokeToken()
    {
        $token = Auth::user()->tokens()->where("name", self::TOKEN_NAME ."-" .session()->getId());
        if ($token) { 
            $token->delete(); 
        }
    }

    public static function generateAccessToken()
    {
        $token = Auth::user()->createToken($sessionTokenName = self::TOKEN_NAME ."-" .session()->getId())->plainTextToken;
        session(['access_token' => $token]);
    }
}
