<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function signupApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'profile' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $image = '';
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $image = rand(1, 999) . '-' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $image);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile' => $image,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Signup successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function getUser()
    {
        $users = User::all();
        echo $users;
    }
}
