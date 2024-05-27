<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->get();

        return response()->json([
            'message' => 'success',
            'data' => $users
        ]);
    }

    public function profile()
    {
        $user = Auth::user();

        return response()->json([
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function search(Request $request)
    {
        $validate = $request->validate([
            'search' => 'required|string|min:3|max:100'
        ]);

        $users = User::where('name', 'like', '%' . $validate['search'] . '%')
            ->orWhere('username', 'like', '%' . $validate['search'] . '%')
            ->orWhere('nim', 'like', '%' . $validate['search'] . '%')
            ->get();

        return response()->json([
            'message' => 'success',
            'data' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'message' => 'success',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }
    }

    public function updateProfile(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $validate = $request->validate([
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
                'nim' => 'string|min:3|max:100|unique:users',
                'username' => 'string|min:3|max:100|unique:users',
                'role_id' => 'integer|exists:roles,id'
            ]);

            if ($request->has('id')) {
                $validate['id'] = $request->id;
            } else {
                $validate['id'] = Auth::id();
            }
        } else {
            $validate = $request->validate([
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

            $validate['id'] = Auth::id();
        }

        $user = User::find($validate['id']);
        $user->update($validate);

        return response()->json([
            'message' => 'User updated',
            'data' => $user
        ]);
    }

    // public function urlmapsgenerator($user)
    // {
    //     $addressComponents = [
    //         $user->address,
    //         $user->rt_number,
    //         $user->rw_number,
    //         $user->village,
    //         $user->district,
    //         $user->city,
    //         $user->province,
    //     ];

    //     // Filter out empty components
    //     $addressComponents = array_filter($addressComponents);

    //     // Concatenate address components into a single address string
    //     $address = implode(', ', $addressComponents);

    //     // URL-encode the address string
    //     $encodedAddress = urlencode($address);

    //     // Formulate the Google Maps search URL
    //     $searchUrl = 'https://www.google.com/maps/search/?api=1&query=' . $encodedAddress;

    //     return $searchUrl;
    // }
}
