<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // agar role check karna ho to yahan logic add karen
    }

    public function rules()
    {
        return [
            'sname' => 'required|string|max:255',
            'fathername' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('students')->where('madrasa_id', auth()->user()->madrasa_id)->ignore($this->route('student'))
            ],
            'class' => 'required|string',
        ];
    }
}