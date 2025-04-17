<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            session()->flash('error', 'Unauthorized access. You do not have admin privileges.');

            // If URL has a previous page, redirect back; otherwise go to welcome route
            return redirect()->to(url()->previous() ?: route('welcome'));
        }

        return $next($request);
    }
}
