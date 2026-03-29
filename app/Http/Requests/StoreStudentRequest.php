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

    public function messages()
    {
        return [
            'code.unique' => 'یہ کوڈ پہلے سے موجود ہے۔ ہر طالب علم کا کوڈ منفرد ہونا چاہیے۔',
            'sname.required' => 'طالب علم کا نام ضروری ہے۔',
            'fathername.required' => 'طالب علم کے باپ کا نام ضروری ہے۔',
            'class.required' => 'طالب علم کی کلاس ضروری ہے۔',
        ];
    }
}