<?php

namespace App\Src\Services\Auth;

use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Src\Base\IBaseService;
use App\Src\Exceptions\AuthorizationException;
use App\Src\Exceptions\NotFoundException;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\Constant;
use App\Src\Validators\AuthValidator;
use Illuminate\Auth\Events\PasswordReset;
use Auth;

class AuthService implements IBaseService {

    const TOKEN_NAME = "auth-token";
    
    protected $model;
    protected $validator;

    public function __construct(User $model, AuthValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance() 
    {
        return new static(new User(), new AuthValidator());
    }

    public function formatResult($model)
    {

    }

    public function register(array $data, $generateToken = true)
    {
        $this->validator->validateRegister($data);

        $data['password'] = bcrypt($data['password']);
        $user = $this->model->create($data);

        $token = null;
        if ($generateToken) {
            // Delete current token to avoid to many auth-token created
            $user->tokens()->where("name", self::TOKEN_NAME)->delete();
            $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;
        }

        $result = [
            "id" => $user->id,
            "name" => $user->name,
            "username" => $user->username,
            "email" => $user->email,
            "status" => Constant::getUserStatus($user->status),
            "token" => $token,
            "user_model" => $user,
        ];

        return $result;
    }

    public function login(array $data)
    {
        $this->validator->validateLogin($data);
        $field = ApiResponse::getField($data);

        $credentials = [$field => @$data["identity"], 'password' => $data["password"], /*'status' => 1*/];

        if (!Auth::attempt($credentials)) {
            throw new AuthorizationException(__("message.login_failed"), [$field => trans('auth.failed')]);
        }

        $user = Auth::user();

        if ($user->email_verified_at == null) {
            throw new AuthorizationException(__("message.email_not_activated"), []);
        }

        // Delete current token to avoid to many auth-token created
        $user->tokens()->where("name", self::TOKEN_NAME)->delete();

        $result = [
            "id" => $user->id,
            "name" => $user->name,
            "username" => $user->username,
            "email" => $user->email,
            "status" => Constant::getUserStatus($user->status),
            "token" => $user->createToken(self::TOKEN_NAME)->plainTextToken,
        ];

        return $result;
    }

    public function logout()
    {
        $result =  Auth::user()->currentAccessToken()->delete();

        return $result;
    }

    public function changeStatus(array $data)
    {
        $this->validator->validateStatus($data);

        $model = $this->findById($data["user_id"]);
        $model->status = $data["status"];
        $model->save();

        return [
            "status" => Constant::getUserStatus($model->status),
        ];
    }

    public function changePassword(array $data)
    {
        $this->validator->validateChangePassword($data);

        $model = $this->findById($data["user_id"]);
        $model->password = bcrypt($data['password']);
        $model->must_change_password = 0;
        $model->save();
    }

    public function getUser()
    {
        $user = Auth::user();
        if (!$user) {
            throw new NotFoundException(__("message.notfound"), []);
        }

        $result = [
            "id" => $user->id,
            "name" => $user->name,
            "username" => $user->username,
            "email" => $user->email,
            "gender" => $user->gender ?? "N/A",
            "profile_picture" => $user->gender ?? "N/A",
            "status" => Constant::getUserStatus($user->status),
        ];

        return $result;
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function forgotpassword(array $data)
    {
        $this->validator->validateEmail($data);

        $status = Password::sendResetLink($data);

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }
        throw new NotFoundException(__("message.notfound"), [
            "status" => \trans($status)
        ]);
    }

}