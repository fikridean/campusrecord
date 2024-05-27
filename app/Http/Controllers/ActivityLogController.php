<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;


class ActivityLogController extends Controller
{
    public function __construct()
    {
        // Apply the isAdmin middleware to all methods in this controller
        $this->middleware('isAdmin');
    }

    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        // Check if a user_id query parameter is provided
        if ($request->has('user_id')) {
            $userId = $request->query('user_id');
            // Validate that user_id is an integer and exists in users table
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            // Fetch activity logs for the specified user
            $activityLogs = ActivityLog::where('user_id', $userId)->get();
        } else {
            // Fetch all activity logs
            $activityLogs = ActivityLog::all();
        }

        return response()->json($activityLogs);
    }

    /**
     * Store a newly created activity log in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|string|max:255',
        ]);

        $activityLog = ActivityLog::create([
            'user_id' => $request->user_id,
            'action' => $request->action,
        ]);

        return response()->json($activityLog, 201);
    }

    /**
     * Display the specified activity log.
     */
    public function show($id)
    {
        $activityLog = ActivityLog::findOrFail($id);
        return response()->json($activityLog);
    }

    /**
     * Update the specified activity log in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|string|max:255',
        ]);

        $activityLog = ActivityLog::findOrFail($id);
        $activityLog->update([
            'user_id' => $request->user_id,
            'action' => $request->action,
        ]);

        return response()->json($activityLog);
    }

    /**
     * Remove the specified activity log from storage.
     */
    public function destroy($id)
    {
        $activityLog = ActivityLog::findOrFail($id);
        $activityLog->delete();

        return response()->json(null, 204);
    }
}
