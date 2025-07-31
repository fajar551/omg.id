<?php
namespace App\Src\Helpers;

use App\Src\Exceptions\ClientException;
use App\Src\Exceptions\ServerException;
use App\Src\Exceptions\ValidatorException;

class ApiResponse
{
	public static function error(\Exception $ex = null, $payloads = [], $code = StatusCode::HTTP_INTERNAL_SERVER_ERROR)
	{
		if (!($ex instanceof ValidatorException)) {
	        activity()
            ->inLog('Error Exception')
			->withProperties(['attributes' => [
                "class" => ApiResponse::class,
                "function" => 'error',
				"code" => $ex->getCode(),
				"message" => $ex->getMessage(),
                "trace" => strtok($ex->getTraceAsString(), '#1')
				]])
				->log($ex->getMessage());
		}
		if ($ex instanceof ClientException || $ex instanceof ServerException) {
			return self::send("error", array_merge($payloads, [
				"message" => $ex->getMessage(),
				"errors" => $ex->getErrors(),
			]), $ex->getCode());
		}


		if ($ex) {
			$payloads = array_merge($payloads, ["message" => $ex->getMessage()]);
		}



		return self::send("error", $payloads, $code);
	}

	public static function success($payloads = [], $code = 200)
	{
		return self::send("success", $payloads, $code);
	}

	public static function send($result = "", $payloads, $code)
	{
		$response = ["code" => $code, "result" => $result];

		return response()->json(array_merge($response, $payloads), $code);
	}

	public static function getField($request) {
        $field = filter_var(@$request["identity"], FILTER_VALIDATE_EMAIL) ? "email" : "username";

        return $field;
    }

}
