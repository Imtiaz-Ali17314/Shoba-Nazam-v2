<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToMadrasa;

class Student extends Model
{
    use HasFactory, BelongsToMadrasa;

    protected $fillable = [
        'madrasa_id',  // Required for BelongsToMadrasa trait
        'sname',
        'fathername',
        'code',
        'class',
    ];

    /**
     * Relationship: Student has many DisciplineRecords
     */
    public function disciplineRecords()
    {
        return $this->hasMany(DisciplineRecord::class);
    }
}