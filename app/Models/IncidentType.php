<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToMadrasa;

class IncidentType extends Model
{
    use HasFactory, BelongsToMadrasa;

    // Agar aap mass assignment ke liye fillable set karna chahte hain
    protected $fillable = [
        'madrasa_id',
        'name',
    ];
}