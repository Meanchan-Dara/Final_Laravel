<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * List all roles
     */
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json($roles, 200);
        } catch (\Exception $e) {
            Log::error('Role index error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve roles'
            ], 500);
        }
    }

    /**
     * Create a new role
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string|unique:roles,name|max:255',
            ]);

            $role = Role::create($fields);

            return response()->json([
                'message' => 'Role created successfully',
                'data'    => $role
            ], 201);
        } catch (\Exception $e) {
            Log::error('Role store error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create role'
            ], 500);
        }
    }

    /**
     * Show a single role
     */
    public function show($id)
    {
        try {
            $role = Role::find($id);

            if (!$role) {
                return response()->json([
                    'message' => 'Role not found'
                ], 404);
            }

            return response()->json($role, 200);
        } catch (\Exception $e) {
            Log::error('Role show error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve role'
            ], 500);
        }
    }

    /**
     * Update a role
     */
    public function update(Request $request, $id)
    {
        try {
            $role = Role::find($id);

            if (!$role) {
                return response()->json([
                    'message' => 'Role not found'
                ], 404);
            }

            $fields = $request->validate([
                'name' => 'required|string|unique:roles,name,' . $role->id . '|max:255',
            ]);

            $role->update($fields);

            return response()->json([
                'message' => 'Role updated successfully',
                'data'    => $role
            ], 200);
        } catch (\Exception $e) {
            Log::error('Role update error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update role'
            ], 500);
        }
    }

    /**
     * Delete a role
     */
    public function destroy($id)
    {
        try {
            $role = Role::find($id);

            if (!$role) {
                return response()->json([
                    'message' => 'Role not found'
                ], 404);
            }

            $role->delete();

            return response()->json([
                'message' => 'Role deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Role delete error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete role'
            ], 500);
        }
    }
}
