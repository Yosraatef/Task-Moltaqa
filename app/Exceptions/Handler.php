<?php

namespace App\Exceptions;

use App\Support\Actions\Response;
use BadMethodCallException;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use Response;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    private mixed $code = 400;

    private array $body = [];

    private string $info = ' Handler Exception ';

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    protected function unauthenticated(
        $request,
        AuthenticationException $exception
    ): \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse {
        return $request->expectsJson()
            ? self::apiResponse($this->code, $exception->getMessage(), info:
                'AuthenticationException '.$this->info.$exception->getMessage())
            : redirect()->guest(route('user.auth.login'));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {

            if ($exception instanceof ValidationException) {
                $errors = $exception->errors();
                $message = '';
                foreach ($errors as $key => $error) {
                    $this->body[$key] = $message = $error[0];
                }

                return self::apiResponse($this->code, $message, $this->body, info:
                    'ValidationException '.
                    $this->info.$exception->getMessage());
            }

            if ($exception instanceof ThrottleRequestsException) {

                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'ThrottleRequestsException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            if ($exception instanceof NotFoundHttpException) {
                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'NotFoundHttpException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof AccessDeniedHttpException) {
                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'AccessDeniedHttpException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof ErrorException) {
                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'ErrorException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof InvalidArgumentException) {
                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'InvalidArgumentException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            if ($exception instanceof MethodNotAllowedHttpException) {
                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'MethodNotAllowedHttpException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            if ($exception instanceof BadMethodCallException) {
                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'BadMethodCallException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            if ($exception instanceof AuthenticationException) {
                return self::apiResponse($this->code, 'Please login first', info:
                    'AuthenticationException '.$this->info.$exception->getMessage());
            }
            if ($exception instanceof ModelNotFoundException) {

                return self::apiResponse($this->code, 'Not have any results', info:
                    'ModelNotFoundException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            // Custom QueryException render.
            if ($exception instanceof QueryException) {


                return self::apiResponse($this->code, $exception->getMessage(), info:
                    'QueryException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
        } elseif (strpos(request()->url(), '/') == false &&
            ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException)) {
            return response()->view('Common::404', ['type' => 404]);
        }

        return parent::render($request, $exception);
    }
}
