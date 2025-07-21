<?php
namespace App\Src\Helpers;

use App\Src\Exceptions\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class SendResponse
{
	
    /**
     * Send the success response.
     * 
     * @param array $result
     * @param string $message
     * @param string $redirectPath
     * @param integer $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
	public static function success($result = [], $message = 'Well done!', $redirectPath = '', $code = 200)
	{
		$response = [
            'code' => $code,
            'status' => 'success',
            'message' => $message,
            'data' => $result,
        ];

		return request()->wantsJson()
                    ? new JsonResponse($response, $code)
                    : redirect($redirectPath)
                            // ->intended($redirectPath)
                            ->withInput()
                            ->with(array_merge($response, ['type' => 'success']));
	}

    /**
     * Send the error response.
     * 
     * @param array $result
     * @param string $message
     * @param string $redirectPath
     * @param Throwable $th
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
	public static function error($result = [], $message = 'Something went wrong!', $redirectPath = '', Throwable $th = null)
	{
        $code = $th ? ($th->getCode() > 505 || $th->getCode() == 0 ? 500 : $th->getCode()) : 500;

        if ($th instanceof ValidationException) {
            $result = $th->errors();
            $code = $th->status;
        }

        if ($th instanceof NotFoundException && !request()->wantsJson()) {
            return abort(404, $th->getMessage()); 
        }

        if (! ($th instanceof ValidationException)) {
            Utils::activityLog('Error Exception!', $th->getMessage(), [
                "class" => SendResponse::class,
                "function" => 'error',
                "code" => $th->getCode(),
                "message" => $th->getMessage(),
                "trace" => strtok($th->getTraceAsString(), '#1')
            ]);
		}

		$response = [
            'code' => $code,
            'status' => 'error',
            'message' => $message,
            'errors' => $result,
        ];

        if (!$redirectPath && !request()->wantsJson()) {
            return abort($code, $message);
        }

		return request()->wantsJson()
                    ? new JsonResponse($response, $code)
                    : redirect($redirectPath)
                            // ->intended($redirectPath)
                            ->withInput()
                            ->withErrors($result)
                            ->with(['type' => 'danger', 'message' => $message]);
	}

}
