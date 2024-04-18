<?php

namespace App\Service;
use App\Models\User;
use App\Models\Role;

class RoleService {

    public function attachRole($user_id, $role) {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Role kontrolü
        if (!$this->roleCheck($role)) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        $userRole = Role::where('user_id', $user_id)->where('role', $role)->first();

        if (!$userRole) {
            Role::create([
                'user_id' => $user_id,
                'role' => $role
            ]);
            return response()->json([
                'message' => 'Role added successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Role already exists'
            ], 400);
        }
    }

    public function roleCheck($role) {
        $allowedRoles = ['admin', 'user', 'moderator'];

        if (!in_array($role, $allowedRoles)) {
            return false;
        }

        return true;
    }

    public function listRoles() {
        $roles = Role::all();
        foreach($roles as $role) {
            $response[] = [
                'id' => $role->id,
                'role' => $role->role,
            ];
        }

        return response()->json([
            'roles' => $response
        ]);
    }

    public function listUsersByRole() {
        $roles = Role::all();
        foreach($roles as $role) {
            $user = User::find($role->user_id);
            $response[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role->role,
            ];
        }
    }

    public function returnUserRole($user_id) {
        $role = Role::where('user_id', $user_id)->first();
        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        return response()->json([
            'role' => $role->role
        ]);
    }
}
