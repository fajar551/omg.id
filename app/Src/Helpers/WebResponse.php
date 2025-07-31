<?php
namespace App\Src\Helpers;

use App\Src\Exceptions\ClientException;
use App\Src\Exceptions\ServerException;
use App\Src\Exceptions\ValidatorException;

class WebResponse
{

    private static $errorName = 'default';

    public static function setErrorName($errorName)
    {
        self::$errorName = $errorName;

        return new static;
    }

	public static function error(\Exception $ex, $route = "", $params = [], $message = "Error!")
	{
        $message = "An error occured: " .(config('app.debug') ? $ex->getMessage() : '');


        if (!($ex instanceof ValidatorException)) {
	        activity()
            ->inLog('Error Exception')
			->withProperties(['attributes' => [
                "route" => $route,
                "class" => WebResponse::class,
                "function" => 'error',
                "error" => $ex->getCode(),
				"message" => $ex->getMessage(),
                "params" => $params,
                "trace" => strtok($ex->getTraceAsString(), '#1')
				]])
				->log($ex->getMessage());
		}
        
		if ($ex instanceof ClientException || $ex instanceof ServerException) {
			$errors = $ex->getErrors();
            $message = $ex->getMessage();

			if (!$route) {
                return self::redirectBack(true, ["message" => $message, "errors" => $errors]);
            }

			return redirect()
					->route($route, $params)
					->withErrors($errors, self::$errorName)
					->withInput()
                    ->with('params', $params)
					->with("type", "danger")
					->with("message", $message);
		}
        
        if (!$route) {
            self::abort($ex->getCode(), $message);

            return self::redirectBack(false, ["message" => $message]);
        }

        if (!($ex instanceof ClientException) || !($ex instanceof ServerException)) {
            // self::abort($ex->getCode(), $message);
        }
		
		return redirect()
                ->route($route, $params)
                ->withInput()
                ->with('params', $params)
                ->with('type', 'danger')
                ->with('message', $message);
	}

	public static function success($message = "Success!", $route = "", $params = [])
	{
		if (!$route) {
            return self::redirectBack(false, ["type" => "success", "message" => $message]);
        }

		return redirect()
                ->route($route, $params)
                ->with("type", "success")
                ->with("message", $message);
	}

	public static function redirectBack($withExtra = false, $params = [])
    {
        if ($withExtra) {
            return redirect()
                    ->back()
                    ->withErrors($params["errors"] ?? [], self::$errorName)
                    ->withInput()
                    ->with("type", $params["type"] ?? "danger")
                    ->with("message", $params["message"] ?? "");
        }

        return redirect()
                ->back()
                ->with('type', $params["type"] ?? "danger")
                ->with('message', $params["message"] ?? "-");
    }

    public static function abort($code, $message)
    {
        switch ($code) {
            case 401: return abort('401', $message);
            case 403: return abort('403', $message);
            case 404: return abort('404', $message);
            case 405: return abort('405', $message);
            case 419: return abort('419', $message);
            case 429: return abort('429', $message);
            case 503: return abort('503', $message);
            default: return abort('500', $message);
        }
    }

}
