<?php
namespace App\Http\Middleware;

use App\Service\RoleService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermission
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
            if ($userRole === "admin") {
                return $next($request);
            } else {
                return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
            }
        } else {
            return response()->json(['message' => "You're not authorized"], 403);
        }
    }

}
