<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // return all users
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

    // return current user
    public function userCurrent(Request $request) {
        $user = $request->user();
        return response()->json([
            'user' => $user
        ]);
    }


}
