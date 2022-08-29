<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateLecturerRequest extends FormRequest
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
        $type = $this->get('type');
        if($type === 'basic') return $this->basic();
        else if($type === 'avatar') return $this->avatar();
        else return $this->password();
    }

    protected function basic(){
        return [
            'first-name' => ['required','regex:/^[A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴÝỶỸ][a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]{1,}$/'],
            'last-name' => ['required','regex:/^[A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴÝỶỸ][a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]{1,}$/'],
            'gender' => 'required|boolean',
            'DoB' => [
                'required',
                'date',
                function($attribute,$value,$onFailure){
                    $dob = Carbon::createFromTimestamp(strtotime($value));
                    if(Carbon::tomorrow()->diffInYears($dob) < 22){
                        $onFailure('New Lecturers have to be more than 22 years old');
                    }
                }],
            'faculty_id' => 'required|exists:App\Models\Faculty,id',
            'title' => 'max:15',
        ];
    }

    protected function avatar(){
        return [
            'avatar' => 'file|image|max:5120',
        ];
    }

    protected function password(){
        return [
            'old-pass' => 'required|min:8',
            'new-pass' => 'required|min:8|different:old-pass'
        ];
    }
}
