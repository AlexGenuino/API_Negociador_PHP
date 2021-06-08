<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'CPF' => ['required', 'string', 'max:11',],
            'name' => ['required', 'string', 'max:255',],
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'birth_date' => 'required'
        ];
    }
}
