<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function fetchData(Request $request)
    {
        // Retrieve the auth_token from the cookies
        $authToken = $request->cookie('auth_token');

        // Check if the auth_token exists
        if (!$authToken) {
            return response()->json(['error' => 'Authentication token not found'], 401);
        }

        // Make an API request with the auth_token
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
        ])->post('http://127.0.0.1:8000/api/login');

        // Check the response status
        if ($response->successful()) {
            $data = $response->json();
            return response()->json($data);
        } else {
            return response()->json(['error' => 'API request failed', 'status' => $response->status(), 'message' => $response->body()], $response->status());
        }
    }
}
