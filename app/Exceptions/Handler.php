<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Psy\Exception\FatalErrorException;
use Exception;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
# use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Exception $exception, $request) {
            /*if ( $exception instanceof FatalErrorException) {
                $this->_notifyThroughSms($exception);
                return response()->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                    'data' => null
                ], 500);
            }*/
            // trim(explode(':', $exception->getMessage())[2]),
            // this will replace 404 response from mvc to a json response
            if ($exception instanceof QueryException) {
                // if the exception is a Database query exeception
                $exMsg = explode('(', $exception->getMessage());
                $count = count($exMsg);
                return response()->json([
                    'error' => $exception->getMessage(),
                ], 400);
            }

            /*if ( $exception instanceof Swift_TransportException ) {
                $this->_notifyThroughSms($exception);
                return response()->json([
                    'title' => 'Host Connection Problem',
                    'message' => 'Please contact administrator',
                    'data' => $exception->getMessage()
                ]);
            }*/

            // This will replace 404 response from the MVC to a JSON response
            if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
                $exMsg = explode('\\', $exception->getModel());
                $count = count($exMsg);
                return response()->json(
                    [
                        'error' =>  'The dataset request for the model ' . $exMsg[$count - 1] . ' is not found',
                    ],
                    404
                );
            }
            // https://stackoverflow.com/questions/53279247/laravel-how-to-show-json-when-api-route-is-wrong-or-not-found
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'error' => 'Invalid Http Url - resource locator not found.',
                ], 404);
            }

            if ($exception instanceof NotFoundResourceException) {
                return response()->json([
                    'error' => 'Resource not found error',
                ], 404);
            }

            if ($exception instanceof RouteNotFoundException) {
                return response()->json([
                    'error' => 'Route not found',
                ], 404);
            }

            if ($exception instanceof ModelNotFoundException) {
                $exMsg = explode('\\', $exception->getModel());
                $count = count($exMsg);
                return response()->json(
                    [
                        'status' => false,
                        'message' =>  'The dataset request for the model ' . $exMsg[$count - 1] . ' is not found',
                        'data' => null
                    ],
                    404
                );
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Http method not valid for this url',
                    'data' => null
                ], Response::HTTP_METHOD_NOT_ALLOWED);
            }

            if ($exception instanceof BindingResolutionException) {
                return response()->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                    'data' => null
                ], 500);
            }

            if ($exception instanceof UnauthorizedHttpException) {

                return response()->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                    'data' => null
                ], 401);
            }

            if ($exception instanceof TokenInvalidException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token supplied is invalid, please login with appropriate credentials',
                    'data' => null
                ], 400);
            }

            if ($exception instanceof TokenExpiredException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token, Login again to get fresh token',
                    'data' => null
                ], 500);
            }

            // JWT Auth related errors
            /*if ($exception instanceof  JWTEx) {
                return response()->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                    'data' => null
                ], 500);
            }*/
        });
    }
}
