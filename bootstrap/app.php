<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Handle ModelNotFoundException for Klant routes
        // Requirements: 8.1, 8.2, 8.3
        $exceptions->renderable(function (ModelNotFoundException $e, Request $request) {
            // Check if this is a ModelNotFoundException for Klant model
            if ($e->getModel() === \App\Models\Klant::class) {
                // Redirect to klanten index with custom error message
                return redirect()
                    ->route('klanten.index')
                    ->with('error', 'Klant niet gevonden');
            }
        });
        
        // Also handle NotFoundHttpException that wraps ModelNotFoundException
        // This is needed for the testing environment
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            // Check if the previous exception was a ModelNotFoundException for Klant
            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException && $previous->getModel() === \App\Models\Klant::class) {
                // Redirect to klanten index with custom error message
                return redirect()
                    ->route('klanten.index')
                    ->with('error', 'Klant niet gevonden');
            }
        });
    })->create();
