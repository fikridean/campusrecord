<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        if (Gate::allows('isAdmin')) {
            return response()->json([
                'message' => 'success',
                'data' => Role::all()
            ]);
        } else {
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
                return response()->json([
                    'message' => 'success',
                    'data' => $role
                ]);
            } else {
                return response()->json([
                    'message' => 'not found',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $role = Role::create($request->all());

            return response()->json([
                'message' => 'success',
                'data' => $role
            ], 201);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function update(Request $request, $id)
    {

        if (Gate::allows('isAdmin')) {
            $role = Role::find($id);

            if ($role) {
                $role->update($request->all());

                return response()->json([
                    'message' => 'success',
                    'data' => $role
                ]);
            } else {
                return response()->json([
                    'message' => 'not found',
                ], 404);
            }
        } else {
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

                return response()->json([
                    'message' => 'success',
                ]);
            } else {
                return response()->json([
                    'message' => 'not found',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
