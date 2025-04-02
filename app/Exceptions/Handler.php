<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*') || $request->is('native/*')) {
                $errors   = [];
                $errorBag = $e->validator->errors();
                $keys     = $errorBag->keys();
                foreach ($keys as $key) {
                    Arr::set(
                        $errors,
                        $key,
                        $errorBag->first($key)
                    );
                }

                return new JsonResponse([
                    'response' => [
                        'message' => 'Validation Error',
                        'errors'  => $errors,
                    ],
                ], 400);

            }
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->is('native/*')) {

                return new JsonResponse([
                    'response' => [
                        'message' => 'Route Not Found Error',
                        'errors'  => "The route " . $request->path() . " could not be found.",
                    ],
                ], 404);

            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Exception) {
            if ($request->is('web/*')) {
                return new JsonResponse([
                    'response' => [
                        'message' => 'Internal Server Error',
                        'errors'  => $exception->getMessage(),
                    ],
                ], 500);
            } else {
                return parent::render($request, $exception);
            }
        }

        return parent::render($request, $exception);
    }
}
