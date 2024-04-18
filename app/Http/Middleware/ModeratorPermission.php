<?php

namespace App\Http\Middleware;

use Closure;
use App\Service\RoleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModeratorPermission
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }


    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user) {
            $userId = $user->id;
            $userRole = $this->roleService->returnUserRole($userId);
            if ($userRole === "moderator" || $userRole === "admin") {
                return $next($request);
            } else {
                return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
            }
        }
    }
}
