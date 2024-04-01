<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;
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
            if ($e instanceof \Illuminate\Session\TokenMismatchException) {
                $url = Request::url();
                Log::debug("message: TokenMismatchException, url: $url");
                return redirect()->route('login')->with('error', 'Your session has expired. Please try again.');
            }
        });
    }

    // public function report(Throwable $e)
    // {
    //     if ($e instanceof \Illuminate\Session\TokenMismatchException) {
    //         return redirect()->route('login')->with('error', 'Your session has expired. Please try again.');
    //     }
    // }
}
