<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        if (Gate::allows('isAdmin')) {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Accessed role list'
            ]);

            return response()->json([
                'message' => 'success',
                'data' => Role::all()
            ]);
        } else {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Tried to access role list but unauthorized'
            ]);

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function show($id)
    {
        if (Gate::allows('isAdmin')) {
            $role = Role::find($id);

            if ($role) {
                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'Accessed role detail'
                ]);

                return response()->json([
                    'message' => 'success',
                    'data' => $role
                ]);
            } else {
                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'Tried to access role detail but not found'
                ]);

                return response()->json([
                    'message' => 'not found',
                ], 404);
            }
        } else {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Tried to access role detail but unauthorized'
            ]);

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $validate = $request->validate([
                'name' => 'required|string|min:3|max:100',
            ]);

            if (!$validate) {
                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'Tried to create a new role but validation error'
                ]);

                return response()->json([
                    'message' => 'validate error',
                    'data' => $validate
                ], 400);
            }

            $role = Role::create($request->all());

            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Created a new role'
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $role
            ], 201);
        } else {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Tried to create a new role but unauthorized'
            ]);

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function update(Request $request, $id)
    {
        if (Gate::allows('isAdmin')) {
            $validate = $request->validate([
                'name' => 'required|string|min:3|max:100',
            ]);

            $role = Role::find($id);

            if ($role) {
                if (!$validate) {
                    ActivityLog::create([
                        'user_id' => Auth::user()->id,
                        'activity' => 'Tried to update a role but validation error'
                    ]);

                    return response()->json([
                        'message' => 'validate error',
                        'data' => $validate
                    ], 400);
                }

                $role->update($validate);

                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'Updated a role'
                ]);

                return response()->json([
                    'message' => 'success',
                    'data' => $role
                ]);
            } else {
                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'Tried to update a role but not found'
                ]);

                return response()->json([
                    'message' => 'not found',
                ], 404);
            }
        } else {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Tried to update a role but unauthorized'
            ]);

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function destroy($id)
    {
        if (Gate::allows('isAdmin')) {
            $role = Role::find($id);

            if ($role) {
                $role->delete();

                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'Deleted a role'
                ]);

                return response()->json([
                    'message' => 'success',
                ]);
            } else {
                ActivityLog::create([
                    'user_id' => Auth::user()->id,
                    'activity' => 'Tried to delete a role but not found'
                ]);

                return response()->json([
                    'message' => 'not found',
                ], 404);
            }
        } else {
            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Tried to delete a role but unauthorized'
            ]);

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
