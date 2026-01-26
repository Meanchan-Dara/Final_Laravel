<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * List all users
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            Log::error('User index error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve users'
            ], 500);
        }
    }

    /**
     * Create a new user
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role_id'  => 'required|exists:roles,id',
            ]);

            $fields['password'] = Hash::make($fields['password']);

            $user = User::create($fields);

            return response()->json([
                'message' => 'User created successfully',
                'data'    => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error('User store error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create user'
            ], 500);
        }
    }

    /**
     * Show a single user
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json($user, 200);
        } catch (\Exception $e) {
            Log::error('User show error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve user'
            ], 500);
        }
    }

    /**
     * Update a user
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            $fields = $request->validate([
                'name'     => 'string|max:255',
                'email'    => ['string', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => 'string|min:6',
                'role_id'  => 'exists:roles,id',
            ]);

            if (isset($fields['password'])) {
                $fields['password'] = Hash::make($fields['password']);
            }

            $user->update($fields);

            return response()->json([
                'message' => 'User updated successfully',
                'data'    => $user
            ], 200);
        } catch (\Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update user'
            ], 500);
        }
    }

    /**
     * Delete a user
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('User delete error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete user'
            ], 500);
        }
    }
}
