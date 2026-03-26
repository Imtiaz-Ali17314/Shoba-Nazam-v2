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
            'student_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('students', 'id')->where('madrasa_id', auth()->user()->madrasa_id),
            ],
            'incident_type_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('incident_types', 'id')->where('madrasa_id', auth()->user()->madrasa_id),
            ],
            'description' => 'required|string',
            'date' => 'required|date',
        ];
    }
}