<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetupRequest;
use App\Models\Madrasa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SetupController extends Controller
{
    /**
     * GET /api/setup/status
     * Check if any madrasa exists
     */
    public function status()
    {
        $exists = Madrasa::exists();

        return response()->json([
            'setup_completed' => $exists
        ]);
    }

    /**
     * POST /api/setup
     * Create madrasa + admin user
     */
    public function store(SetupRequest $request) // ← type-hint changed
    {
        // Check if already setup
        if (Madrasa::exists()) {
            return response()->json([
                'message' => 'Setup already completed.'
            ], 403);
        }

        // Validated data automatically
        $data = $request->validated();

        // Create Madrasa
        $madrasa = Madrasa::create([
            'name' => $data['site_name'],
        ]);

        // Create Admin User
        $user = User::create([
            'name'       => $data['admin_name'] ?? 'Admin', // optional fallback
            'email'      => $data['admin_email'],
            'password'   => Hash::make($data['admin_password']),
            'madrasa_id' => $madrasa->id,
        ]);

        // Assign Admin Role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $user->assignRole($adminRole);
        }

        return response()->json([
            'message' => 'Setup completed successfully',
            'madrasa' => $madrasa,
            'user'    => $user
        ]);
    }
}