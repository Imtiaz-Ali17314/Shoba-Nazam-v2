<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToMadrasa
{
    /**
     * Boot the trait and add global scope
     */
    public static function bootBelongsToMadrasa()
    {
        // Global scope: automatically filter queries by madrasa_id
        static::addGlobalScope('madrasa_id', function (Builder $builder) {
            if ($madrasaId = self::currentMadrasaId()) {
                $builder->where('madrasa_id', $madrasaId);
            }
        });

        // Auto-set madrasa_id on create
        static::creating(function ($model) {
            if (empty($model->madrasa_id) && $madrasaId = self::currentMadrasaId()) {
                $model->madrasa_id = $madrasaId;
            }
        });
    }

    /**
     * Helper to get current madrasa_id
     * Example: from logged-in user or session
     */
    protected static function currentMadrasaId()
    {
        // If user is logged in and has madrasa_id
        if (Auth::check() && isset(Auth::user()->madrasa_id)) {
            return Auth::user()->madrasa_id;
        }

        // Fallback: get madrasa_id from session (optional)
        return session('madrasa_id', null);
    }
}