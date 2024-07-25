<?php

namespace App\Exceptions;

use App\Services\ApiResponseService;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;
use function Laravel\Prompts\error;

class ErrorMsgException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message = $message ?: trans('response.wrong');
        $this->code = $code ?: 400;

        parent::__construct($this->message, $this->code, $previous);
    }

    public function render($request)
    {
        return ApiResponseService::errorResponse(errors: [$this->message]);
    }

    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error('Error: ' . $this->message);
    }
}
