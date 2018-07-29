<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * @var string[] $dontFlash
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param  Exception $exception
     * @return mixed
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        return parent::report($exception);
    }

    /**
     * @param  Request $request
     * @param  Exception $exception
     * @return Response
     */
    public function render($request, Exception $exception): Response
    {
        return parent::render($request, $exception);
    }
}
