<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function userList() {
        $users = User::all();
        foreach($users as $user) {
            $response[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ];
        }

        return response()->json([
            'users' => $response
        ]);
    }

    public function userCurrent(Request $request) {
        $user = $request->user();
        return response()->json([
            'user' => $user
        ]);
    }

    public function userLogin(Request $request) {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'message' => 'Login failed'
        ]);
    }
}
