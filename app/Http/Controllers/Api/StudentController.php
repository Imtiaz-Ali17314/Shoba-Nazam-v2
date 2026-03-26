<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest; // ← yahan add kiya
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * GET /api/students
     * List with pagination + search
     */
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sname', 'like', "%{$search}%")
                  ->orWhere('fathername', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->user()) {
            $query->where('madrasa_id', $request->user()->madrasa_id);
        }

        $students = $query->latest()->paginate(10);

        return response()->json($students);
    }

    /**
     * POST /api/students
     */
    public function store(StoreStudentRequest $request) // ← type-hint changed
    {
        $data = $request->validated(); // ← validated data automatically milega
        $data['madrasa_id'] = $request->user()->madrasa_id;

        $student = Student::create($data);

        return response()->json([
            'message' => 'Student created successfully',
            'data'    => $student
        ], 201);
    }

    /**
     * GET /api/students/{id}
     */
    public function show($id, Request $request)
    {
        $student = Student::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        return response()->json($student);
    }

    /**
     * PUT /api/students/{id}
     */
    public function update(StoreStudentRequest $request, $id) // ← type-hint changed
    {
        $student = Student::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        $data = $request->validated();
        $student->update($data);

        return response()->json([
            'message' => 'Student updated successfully',
            'data'    => $student
        ]);
    }

    /**
     * DELETE /api/students/{id}
     */
    public function destroy(Request $request, $id)
    {
        $student = Student::where('madrasa_id', $request->user()->madrasa_id)
            ->findOrFail($id);

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully'
        ]);
    }
}