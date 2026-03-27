<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display all users
     */
    public function index()
    {
        $users = User::with('roles', 'madrasa')->latest()->paginate(10);

        return response()->json($users);
    }

    /**
     * Store new user + assign role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'madrasa_id' => auth()->user()->madrasa_id,
            'is_active' => true,
        ]);

        // Assign role
        $user->assignRole($request->role);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->load('roles')
        ]);
    }

    /**
     * Show single user
     */
    public function show($id)
    {
        $user = User::with('roles', 'madrasa')->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update user + role update
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'role' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update role
        $user->syncRoles([$request->role]);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->load('roles')
        ]);
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Activate / Deactivate user
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'message' => 'User status updated',
            'is_active' => $user->is_active
        ]);
    }
}