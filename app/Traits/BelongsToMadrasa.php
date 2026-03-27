<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToMadrasa
{
    public static function bootBelongsToMadrasa()
    {
        // ✅ Global scope with table prefix
        static::addGlobalScope('madrasa_id', function (Builder $builder) {
            if ($madrasaId = self::currentMadrasaId()) {

                $table = $builder->getModel()->getTable();

                $builder->where($table . '.madrasa_id', $madrasaId);
            }
        });

        // Auto-set madrasa_id on create
        static::creating(function ($model) {
            if (empty($model->madrasa_id) && $madrasaId = self::currentMadrasaId()) {
                $model->madrasa_id = $madrasaId;
            }
        });
    }

    protected static function currentMadrasaId()
    {
        if (Auth::check() && isset(Auth::user()->madrasa_id)) {
            return Auth::user()->madrasa_id;
        }

        return session('madrasa_id', null);
    }
}