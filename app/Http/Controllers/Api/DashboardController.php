<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\DisciplineRecord;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total students
        $totalStudents = Student::count();

        // Total records
        $totalRecords = DisciplineRecord::count();

        // Records by class
        $recordsByClass = DisciplineRecord::select('class', DB::raw('count(*) as total'))
            ->groupBy('class')
            ->get();

        // Records by month (current year)
        $recordsByMonth = DisciplineRecord::select(DB::raw("MONTH(created_at) as month"), DB::raw("count(*) as total"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy('month')
            ->get();

        return response()->json([
            'total_students' => $totalStudents,
            'total_records' => $totalRecords,
            'records_by_class' => $recordsByClass,
            'records_by_month' => $recordsByMonth,
        ]);
    }
}