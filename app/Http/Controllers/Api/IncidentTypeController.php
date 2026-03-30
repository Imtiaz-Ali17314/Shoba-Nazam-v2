<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncidentType;

class IncidentTypeController extends Controller
{
    /**
     * GET /api/incident-types
     * List all incident types (with pagination)
     */
    public function index(Request $request)
    {
        $query = IncidentType::where('madrasa_id', $request->user()->madrasa_id);

        // Optional search
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->all) {
            return response()->json($query->orderBy('name')->get());
        }

        $types = $query->latest()->paginate(10);

        return response()->json($types);
    }

    /**
     * POST /api/incident-types
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Prevent duplicate names per madrasa
        $exists = IncidentType::where('madrasa_id', $request->user()->madrasa_id)
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Incident type already exists'
            ], 422);
        }

        $validated['madrasa_id'] = $request->user()->madrasa_id;

        $type = IncidentType::create($validated);

        return response()->json([
            'message' => 'Incident type created successfully',
            'data'    => $type
        ], 201);
    }

    /**
     * GET /api/incident-types/{id}
     */
    public function show(Request $request, $id)
    {
        $type = IncidentType::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        return response()->json($type);
    }

    /**
     * PUT /api/incident-types/{id}
     */
    public function update(Request $request, $id)
    {
        $type = IncidentType::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Prevent duplicate (ignore current id)
        $exists = IncidentType::where('madrasa_id', $request->user()->madrasa_id)
            ->where('name', $validated['name'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Incident type already exists'
            ], 422);
        }

        $type->update($validated);

        return response()->json([
            'message' => 'Incident type updated successfully',
            'data'    => $type
        ]);
    }

    /**
     * DELETE /api/incident-types/{id}
     */
    public function destroy(Request $request, $id)
    {
        $type = IncidentType::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        $type->delete();

        return response()->json([
            'message' => 'Incident type deleted successfully'
        ]);
    }
}