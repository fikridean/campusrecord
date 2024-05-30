<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        if (Gate::allows('isAdmin')) {
            $users = User::all();
        } else {
            $users = User::where(['role_id' => 2])->get();
        }

        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Accessed user list'
        ]);

        return view('dashboard', [
            'users' => $users
        ]);
    }

    public function profile()
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Accessed own profile'
        ]);

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

        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Searched for user'
        ]);

        return redirect(Route('dashboardSearchUser'))->with(['users' => $users]);

        // return view('dashboard', [
        //     'users' => $users
        // ]);

        // return response()->json([
        //     'message' => 'success',
        //     'data' => $users
        // ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Accessed user detail'
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $user,
            ]);
        } else {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Tried to access user detail but not found'
            ]);

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
                'map_url' => 'string|min:3|max:100',
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

        ActivityLog::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Updated user profile'
        ]);

        return response()->json([
            'message' => 'User updated',
            'data' => $user
        ]);
    }

    public function activities()
    {
        $activities = ActivityLog::where('user_id', Auth::id())->get();

        return response()->json([
            'message' => 'success',
            'data' => $activities
        ]);
    }

    public function allActivities()
    {
        if (Gate::allows('isAdmin')) {
            $activities = ActivityLog::all();

            return response()->json([
                'message' => 'success',
                'data' => $activities
            ]);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }
}
