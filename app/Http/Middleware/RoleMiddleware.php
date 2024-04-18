<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function adminPermission(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
        }

        return $next($request);
    }

    public function moderatorPermission(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'moderator'|| $request->user()->role !== 'admin') {
            return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
        }

        return $next($request);
    }

    public function userPermission(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'user' || $request->user()->role !== 'moderator' || $request->user()->role !== 'admin') {
            return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
        }

        return $next($request);
    }
}
