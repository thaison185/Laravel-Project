<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreStudentRequest extends FormRequest
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

    public function rules()
    {
        if($this->has('type')){
            $type = $this->get('type');
            if($type === 'basic') return $this->basic();
            else if($type === 'avatar') return $this->avatar();
            else return $this->password();
        }
        return $this->insert();
    }

    protected function basic(){
        return [
            'first-name' => ['required','regex:/^[A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴÝỶỸ][a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]{1,}$/'],
            'last-name' => ['required','regex:/^[A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴÝỶỸ][a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]{1,}$/'],
            'gender' => 'required|boolean',
            'DoB' => [
                'required',
                'date_format:d/m/Y',
                function($attribute,$value,$onFailure){
                    $dob = Carbon::createFromTimestamp(strtotime($value));
                    if(Carbon::tomorrow()->diffInYears($dob) < 17){
                        $onFailure('New Lecturers have to be more than 18 years old');
                    }
                }],
            'class_id' => 'required|exists:App\Models\Classs,id',
            'phone' => ['required','regex:/^\+84 [0-9]+$/'],
        ];
    }

    protected function avatar(){
        return [
            'avatar' => 'file|image|max:5120',
        ];
    }

    protected function password(){
        return [
            'new-pass' => 'required|min:8'
        ];
    }

    protected function insert(){
        return [
            'email' => 'required|email|unique:App\Models\Student,email',
            'password' => 'required|min:8',
            'first-name' => ['required','regex:/^[A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴÝỶỸ][a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]{1,}$/'],
            'last-name' => ['required','regex:/^[A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴÝỶỸ][a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]{1,}$/'],
            'gender' => 'required|boolean',
            'DoB' => [
                'required',
                'date_format:d/m/Y',
                function($attribute,$value,$onFailure){
                    $dob = Carbon::createFromTimestamp(strtotime($value));
                    if(Carbon::tomorrow()->diffInYears($dob) < 17){
                        $onFailure('New Lecturers have to be more than 18 years old');
                    }
                }],
            'class_id' => 'required|exists:App\Models\Classs,id',
            'phone' => ['required','regex:/^\+84 [0-9]+$/'],
            'avatar' => 'file|image|max:5120',
        ];
    }
}
