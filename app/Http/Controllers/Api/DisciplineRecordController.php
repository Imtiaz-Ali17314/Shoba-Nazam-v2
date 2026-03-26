<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDisciplineRecordRequest; // ← import kiya
use App\Models\DisciplineRecord;
use Illuminate\Http\Request;

class DisciplineRecordController extends Controller
{
    /**
     * GET /api/discipline-records
     * List with pagination + filters
     */
    public function index(Request $request)
    {
        $query = DisciplineRecord::with(['student', 'incidentType'])
            ->where('madrasa_id', $request->user()->madrasa_id);

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->incident_type_id) {
            $query->where('incident_type_id', $request->incident_type_id);
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        $records = $query->latest()->paginate(10);

        return response()->json($records);
    }

    /**
     * POST /api/discipline-records
     */
    public function store(StoreDisciplineRecordRequest $request) // ← type-hint changed
    {
        $data = $request->validated(); // ← validated data automatically
        $data['madrasa_id'] = $request->user()->madrasa_id;

        $record = DisciplineRecord::create($data);

        return response()->json([
            'message' => 'Record created successfully',
            'data'    => $record->load(['student', 'incidentType'])
        ], 201);
    }

    /**
     * GET /api/discipline-records/{id}
     */
    public function show(Request $request, $id)
    {
        $record = DisciplineRecord::with(['student', 'incidentType'])
            ->where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        return response()->json($record);
    }

    /**
     * PUT /api/discipline-records/{id}
     */
    public function update(StoreDisciplineRecordRequest $request, $id) // ← type-hint changed
    {
        $record = DisciplineRecord::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        $record->update($request->validated());

        return response()->json([
            'message' => 'Record updated successfully',
            'data'    => $record->load(['student', 'incidentType'])
        ]);
    }

    /**
     * DELETE /api/discipline-records/{id}
     */
    public function destroy(Request $request, $id)
    {
        $record = DisciplineRecord::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        $record->delete();

        return response()->json([
            'message' => 'Record deleted successfully'
        ]);
    }
}