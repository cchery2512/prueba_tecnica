<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use \Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use \Illuminate\Auth\Access\AuthorizationException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use \Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    use ApiResponser;
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

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    //public function report(Throwable $exception);
    //public function render($request, Throwable $exception);

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof AuthenticationException) {
            if($exception->getMessage() == 'Unauthenticated.'){
                return $this->errorResponse('Usted no esta debidamente autenticado', 401);
               // return response()->json([ 'ok' => false,'error' => '401','mensaje' => 'Usted no esta debidamente autenticado']);
            }

        }

        if($exception instanceof HttpException){
            return $this->errorResponse('La URL introducida no existe', $exception->getStatusCode());
            //return response()->json([ 'ok' => false,'error' => '404','mensaje' => 'La URL introducida no existe']);
        }

        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse('No existe ninguna instancia de ' . $model . ' con el id especificado', 404);
        }

        if($exception instanceof AuthorizationException){
            return $this->errorResponse('No tiene permisos para acceder a los recursos de esta peticion', 403);
            //return response()->json([ 'ok' => false,'error' => '403','mensaje' => 'No tiene permisos para acceder a los recursos de esta peticion']);
        }
        if($exception instanceof ValidationException){
            //$errors = implode(', ', $exception->validator->errors()->all());
            $errors = $exception->validator->errors()->all();
            return $this->errorResponse($errors, 422);
        }

        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('El método especificado en la petición no es valido', 404);
        }

        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('La URL introducida no existe', 404);
        }

        if($exception instanceof QueryException){
            $code = $exception->errorInfo[1];
            if($code == 1451){
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque está relacionado con otro.', 409);
            }
        }

        if($exception instanceof QueryException){
            $code = $exception->errorInfo[1];
            if($code == 1062){
                return $this->errorResponse('Ya existe un registro con esos datos.', 409);
            }
        }

        if(config('app.debug')){
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Falla inesperada.', 500);
    }
}