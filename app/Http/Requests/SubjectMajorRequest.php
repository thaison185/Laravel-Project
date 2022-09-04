<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectMajorRequest extends FormRequest
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
            'major_id' => 'required|exists:\App\Models\Major,id',
            'subject_id' => 'required|exists:\App\Models\Subject,id',
            'lecturer_hour' => 'required|numeric|min:70|max:300',
            'semester' => 'required|min:1|max:14',
        ];
    }
}
