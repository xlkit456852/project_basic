<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof \Bican\Roles\Exceptions\PermissionDeniedException ||
            $e instanceof \Bican\Roles\Exceptions\LevelDeniedException ||
            $e instanceof \Bican\Roles\Exceptions\RoleDeniedException)
        {
            $message = '你的管理权限不足，无法访问！';

            if(Request::ajax()){
                return response([
                    'status'=>0,
                    'info'  =>$message
                ]);
            }else{
                return view('admin.error',compact('message'));
            }
        }

        return parent::render($request, $e);
    }
}
