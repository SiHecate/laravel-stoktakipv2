<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function adminPermission(Request $request, Closure $next): Response
    {
        // Admin kullanıcısı kontrol ediliyor.
        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        // Admin kullanıcısı değilse 403 hatası döndürülüyor.
        return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
    }

    public function moderatorPermission(Request $request, Closure $next): Response
    {
        // Kullanıcı moderatör veya admin mi kontrol ediliyor.
        if ($request->user()->role === 'moderator' || $request->user()->role === 'admin') {
            return $next($request);
        }

        // Moderatör veya admin değilse 403 hatası döndürülüyor.
        return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
    }

    public function userPermission(Request $request, Closure $next): Response
    {
        // Kullanıcı normal kullanıcı, moderatör veya admin mi kontrol ediliyor.
        if ($request->user()->role === 'user' || $request->user()->role === 'moderator' || $request->user()->role === 'admin') {
            return $next($request);
        }

        // Belirtilen rollere sahip değilse 403 hatası döndürülüyor.
        return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
    }
}
