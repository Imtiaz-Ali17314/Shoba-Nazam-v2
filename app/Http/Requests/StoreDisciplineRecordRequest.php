<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDisciplineRecordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'incident_type_id' => 'required|exists:incident_types,id',
            'description' => 'required|string',
            'date' => 'required|date',
        ];
    }
}