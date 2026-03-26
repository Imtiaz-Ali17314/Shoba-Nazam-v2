<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Madrasa extends Model
{
    protected $fillable = [
        'name', 
        'address', 
        'email', 
        'phone',
        'academic_year'
    ];

    // One Madrasa has many Users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // One Madrasa has many Students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // One Madrasa has many Incident Types
    public function incidentTypes()
    {
        return $this->hasMany(IncidentType::class);
    }

    // One Madrasa has many Discipline Records
    public function disciplineRecords()
    {
        return $this->hasMany(DisciplineRecord::class);
    }
}