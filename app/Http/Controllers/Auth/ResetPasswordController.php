<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Src\Exceptions\ClientException;
use App\Src\Exceptions\ServerException;
use App\Src\Services\Auth\AuthService;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function showChangePasswordForm(Request $request)
    {
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request, AuthService $authService)
    {
        try {
            $data = $request->input();
            $data["user_id"] = auth()->user()->id;

            $authService->changePassword($data);

            return redirect()->route('home');
        } catch (\Exception $ex) {
            $errors = [];
            $message = $ex->getMessage();

            if ($ex instanceof ClientException || $ex instanceof ServerException) {
                $errors = $ex->getErrors();
            }

            return redirect()
                    ->route("password.change.index")
                    ->withInput()
                    ->with(["type" => "danger", "message" => $message])
                    ->withErrors($errors);
        }

    }
}
