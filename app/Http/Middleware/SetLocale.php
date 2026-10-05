<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->cookie('lang', 'id');
        // Only allow 'id' or 'en' for security
        $locale = in_array($lang, ['id', 'en']) ? $lang : 'id';
        app()->setLocale($locale);

        return $next($request);
    }
}
