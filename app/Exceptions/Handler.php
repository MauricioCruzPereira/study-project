<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if($e instanceof ModelNotFoundException){
            return response()->json([
                "message" => "Sem resultados para a sua pesquisa"
            ], Response::HTTP_NOT_FOUND);
        }
        if($e instanceof ValidationException){
            return response()->json([
                "message" => "Credenciais incorretas"
            ], Response::HTTP_UNAUTHORIZED);
        }
        dd($e);
        parent::render($request, $e);
    }
}
