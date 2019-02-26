<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        // 操作频繁
        if ($exception->getMessage() === "Too Many Attempts.") {
            return response()->json(error('操作频繁'), 422);
        }
        // 验证错误
        if ($exception instanceof ValidationException) {
            return response()->json(error(array_first(array_collapse($exception->errors()))), 422);
        }
        // token
        if ($exception instanceof AuthenticationException) {
            return response()->json(error('无效 token'), 403);
        }

        return parent::render($request, $exception);
    }
}
