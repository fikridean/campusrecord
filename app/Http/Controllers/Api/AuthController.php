<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|unique:users|min:3|max:100',
            'nim' => 'required|string|unique:users|min:3|max:100',
            'date_of_birth' => 'required|string|min:3|max:50',
            'address' => 'required|string|min:3|max:100',
            'rt_number' => 'required|string|min:2|max:100',
            'rw_number' => 'required|string|min:2|max:100',
            'village' => 'required|string|min:3|max:100',
            'district' => 'required|string|min:3|max:100',
            'city' => 'required|string|min:3|max:100',
            'province' => 'required|string|min:3|max:100',
            'phone_number' => 'required|string|min:3|max:100',
            'hobby' => 'required|string|min:3|max:100',
            'password' => 'required|string|min:3|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create($request->all());

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function updatePassword(Request $request)
    {
        // { REQUEST EXAMPLE
        //     "current_password": "currentPassword123",
        //     "new_password": "newPassword123",
        //     "new_password_confirmation": "newPassword123"
        // }

        // Get the ID of the user to update, considering admin privileges
        if (Gate::allows('isAdmin')) {


            if ($request->has('id')) {
                $validate = $request->validate([
                    'new_password' => 'required|string|min:8|confirmed',
                    'id' => 'integer|exists:users,id'
                ]);
            } else {
                $validate = $request->validate([
                    'current_password' => 'string|min:8',
                    'new_password' => 'required|string|min:8|confirmed',
                ]);

                $validate['id'] = Auth::id();
            }
        } else {
            $validate = $request->validate([
                'current_password' => 'required|string|min:8',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $validate['id'] = Auth::id();
        }

        // Find the user
        $user = User::find($validate['id']);

        if (Gate::allows('isAdmin')) {
            if (!$request->id) {
                if (!Hash::check($validate['current_password'], $user->password)) {
                    return response()->json([
                        'message' => 'Current password is incorrect'
                    ], 400);
                }
            }
        } else {
            // Check if the current password matches
            if (!Hash::check($validate['current_password'], $user->password)) {
                return response()->json([
                    'message' => 'Current password is incorrect'
                ], 400);
            }
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Username / Password Salah'
            ], 401);
        }

        $user = User::where('username', $request->username)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
