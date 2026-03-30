<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToMadrasa;

class AuditLog extends Model
{
    use HasFactory, BelongsToMadrasa;

    // Mass assignment ke liye
    protected $fillable = [
        'madrasa_id',
        'user_id',
        'action',
        'model_type',
        'model_id',
        'changes',
    ];

    // User relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for changes JSON
    protected $casts = [
        'changes' => 'array',
    ];
}