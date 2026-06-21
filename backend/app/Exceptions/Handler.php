<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            return $this->buildJsonResponse($e);
        }

        return parent::render($request, $e);
    }

    /**
     * Build a JSON response for exceptions.
     *
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function buildJsonResponse(Throwable $e)
    {
        $statusCode = 500;
        $message = 'Erro interno no servidor.';
        $errors = null;

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $statusCode = 422;
            $message = 'Os dados fornecidos são inválidos.';
            $errors = $e->errors();
        } elseif ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $statusCode = 404;
            $message = 'Registro não encontrado.';
        } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $statusCode = 404;
            $message = 'Rota não encontrada.';
        } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
            $statusCode = 401;
            $message = 'Não autenticado.';
        } elseif ($this->isHttpException($e)) {
            /**
             * @var HttpExceptionInterface $e
            */
            $statusCode = $e->getStatusCode();
            $message = $e->getMessage() ?: 'Erro de requisição.';
        }

        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
