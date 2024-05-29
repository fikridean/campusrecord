<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\ActivityLog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

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
            'map_url' => 'required|string|min:3|max:100',
            'phone_number' => 'required|string|min:3|max:100',
            'hobby' => 'required|string|min:3|max:100',
            'password' => 'required|string|min:3|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create($request->all());

        $token = $user->createToken('auth_token')->plainTextToken;

        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Registered'
        ]);

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function updatePassword(Request $request)
    {
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

        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Password updated'
        ]);

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {

            return response()->json([
                'message' => 'Wrong login details'
            ], 401);
        }

        $request->session()->regenerate();

        $user = User::where('username', $request->username)->firstOrFail();

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        // $response = new Response('Bearer Token');
        // $response->withCookie(cookie('auth_token', $token, 62500));

        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Logged in'
        ]);

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        auth()->guard('web')->logout();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Logged out'
        ]);

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
