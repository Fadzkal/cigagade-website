<?php

namespace App\Http\Middleware;

use App\Services\VisitorService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    protected VisitorService $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests for web pages
        if ($request->isMethod('GET') && !$request->ajax() && !$request->wantsJson()) {
            $path = trim($request->path(), '/');

            // Excluded paths: dashboard, api, livewire, storage, up, auth/logout etc.
            $isExcluded = str_starts_with($path, 'dashboard')
                || str_starts_with($path, 'api')
                || str_starts_with($path, 'livewire')
                || str_starts_with($path, 'storage')
                || str_starts_with($path, 'build')
                || str_starts_with($path, '_')
                || $path === 'up'
                || $path === 'logout';

            if (!$isExcluded) {
                $this->visitorService->recordVisit($request);
            }
        }

        return $next($request);
    }
}
