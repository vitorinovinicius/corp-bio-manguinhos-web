<?php

namespace App\Exceptions;

use Throwable;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Artesaos\Defender\Exceptions\ForbiddenException;
use App\Http\CspPolicies\FSMPolicy;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;

class Handler extends ExceptionHandler
{
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        
        if ($exception instanceof ForbiddenException) {
            return redirect()->back()->with("error", "Você não possui permissões para acessar este conteúdo");
        }

        // Habilitando diretivas do CSP no caso de erros do sistema (Pagina Whoops)
        $this->container->singleton(FSMPolicy::class, function ($app) {
            return new FSMPolicy();
        });
        app(FSMPolicy::class)->addDirective(Directive::SCRIPT, Keyword::UNSAFE_INLINE);
        app(FSMPolicy::class)->addDirective(Directive::STYLE, Keyword::UNSAFE_INLINE);

        return parent::render($request, $exception);
       
    }
}
