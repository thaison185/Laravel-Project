<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->user()->role == '1');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'major_id'=>'required|exists:\App\Models\Major,id',
            'admission_year'=>'required|digits:4',
        ];
    }
}
