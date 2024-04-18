<?php

namespace App\Service;

use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RoleService {
    public function attachRole(int $userId, string $role): Response {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!$this->isValidRole($role)) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        if (!$this->hasRole($userId, $role)) {
            Role::create([
                'user_id' => $userId,
                'role' => $role,
            ]);
            return response()->json(['message' => 'Role added successfully'], 200);
        } else {
            return response()->json(['message' => 'Role already exists'], 400);
        }
    }

    public function getRoles(): array {
        return Role::all()->toArray();
    }

    public function getUserWithRoles(): Response {
        $userList = User::all();
        $users = [];
        foreach ($userList as $user) {
            $role = Role::where('user_id', $user->id)->first();

            if ($role) {
                $users[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role->role,
                ];
            }
        }
        return response()->json($users, 200);

    }

    public function getUserRole(int $userId): ?string {
        $role = Role::where('user_id', $userId)->first();
        return $role ? $role->role : null;
    }

    private function isValidRole(string $role): bool {
        $allowedRoles = ['admin', 'user', 'moderator'];
        return in_array($role, $allowedRoles);
    }

    private function hasRole(int $userId, string $role): bool {
        return Role::where('user_id', $userId)->where('role', $role)->exists();
    }

    public function returnUserRole(int $userId) {
        $role = Role::where('user_id', $userId)->first();
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return $role->role;
    }
}
