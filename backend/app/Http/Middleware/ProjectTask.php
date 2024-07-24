<?php

namespace App\Http\Middleware;

use App\Services\Project\ProjectServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectTask
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $project = app(ProjectServiceInterface::class)->find(request('projectId'));

        return $project ? $next($request) : 'Unauthorized';
    }
}
