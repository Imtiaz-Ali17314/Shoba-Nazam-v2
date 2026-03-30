<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToMadrasa;

class DisciplineRecord extends Model
{
    use HasFactory, BelongsToMadrasa;

    // Mass assignment ke liye fillable
    protected $fillable = [
        'madrasa_id',
        'student_id',
        'incident_type_id',
        'detail',
        'date',
    ];

    // Student relation
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // IncidentType relation
    public function incidentType()
    {
        return $this->belongsTo(IncidentType::class);
    }
}