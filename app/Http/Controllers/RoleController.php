<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Service\RoleService;
use Illuminate\Http\Request;

class RoleController {

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function AttacRole(Request $request) {
        $role = $request->role;
        $user_id = $request->user_id;
        return $this->roleService->attachRole($role, $user_id);
    }

    public function RoleList() {
        return $this->roleService->getRoles();
    }

    public function UserRoleList() {
        return $this->roleService->getUserWithRoles();
    }

    public function returnUserRole(Request $request) {
        $user_id = $request->user()->id;
        return $this->roleService->returnUserRole($user_id);
    }
}
