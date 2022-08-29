<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'type' => 'required|in:preview,import',
            'file' => ['required','mimes:csv,xls,xlsx,txt']
        ];
    }

    public function messages()
    {
        return [
            'type.in' => "Someone modified the request. We accept only preview and import for 'type'!",
//            'file.mimes' => "Sorry, we only support .xls, .xlsx, .csv files!"
        ];
    }
}
