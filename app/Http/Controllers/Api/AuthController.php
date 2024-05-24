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

    public function update(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $id = $request->id;
        } else {
            $id = Auth::id();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|min:3|max:100',
            'date_of_birth' => 'string|min:3|max:50',
            'address' => 'string|min:3|max:100',
            'rt_number' => 'string|min:2|max:100',
            'rw_number' => 'string|min:2|max:100',
            'village' => 'string|min:3|max:100',
            'district' => 'string|min:3|max:100',
            'city' => 'string|min:3|max:100',
            'province' => 'string|min:3|max:100',
            'phone_number' => 'string|min:3|max:100',
            'hobby' => 'string|min:3|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($id);
        $user->update($request->all());

        return response()->json([
            'message' => 'User updated',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
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
