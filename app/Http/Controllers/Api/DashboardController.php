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

        // Records by class (via student relationship) - Efficient database level grouping
        $recordsByClass = \App\Models\DisciplineRecord::join('students', 'discipline_records.student_id', '=', 'students.id')
            ->select('students.class', \Illuminate\Support\Facades\DB::raw('count(discipline_records.id) as total'))
             ->where('discipline_records.madrasa_id', auth()->user()->madrasa_id)
            ->groupBy('students.class')
            ->get();

        // Records by month (current year)
        $recordsByMonth = DisciplineRecord::select(DB::raw("MONTH(date) as month"), DB::raw("count(*) as total"))
            ->whereYear('date', '=', date('Y'))
            ->groupBy(DB::raw("MONTH(date)"))
            ->orderBy('month', 'asc')
            ->get();

        // This month's records
        $thisMonthRecords = DisciplineRecord::whereYear('date', '=', date('Y'))
            ->whereMonth('date', '=', date('m'))
            ->count();

        return response()->json([
            'total_students'    => $totalStudents,
            'total_records'     => $totalRecords,
            'this_month_records'=> $thisMonthRecords,
            'records_by_class'  => $recordsByClass,
            'records_by_month'  => $recordsByMonth,
        ]);
    }
}