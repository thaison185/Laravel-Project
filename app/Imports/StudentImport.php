<?php

namespace App\Imports;

use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToModel,WithHeadingRow,WithValidation,SkipsOnError,SkipsOnFailure,SkipsEmptyRows
{
    use SkipsErrors,SkipsFailures,Importable;

    private $extension;

    private $rows = 0;

    public function __construct($extension){
        $this->extension=$extension;
    }

    public function model(array $row)
    {
        ++$this->rows;
        return new Student([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'gender' => $row['gender'],
            'phone' => $row['phone'],
            'DoB' => Carbon::createFromTimestamp(strtotime($row['dob']))->toDateString(),
            'description' => $row['description'],
            'class_id' => $row['class_id'] ?? $row['class'],
        ]);
    }


    public function rules(): array
    {
        return [
            'name' => ['required','max:30','regex:/^[A-Z][a-zA-Z ]{1,}$/'],
            'email' => ['required','email'],
            'password' => ['required','min:8'],
            'gender' => ['required','in:0,1'],
            'dob' => [
                'required',
                'date',
                function($attribute,$value,$onFailure){
                    $dob = Carbon::createFromTimestamp(strtotime($value));
                    if(Carbon::tomorrow()->diffInYears($dob) < 17){
                        $onFailure('New Lecturers have to be more than 18 years old');
                    }
                }
            ],
            'class_id' => ['required','exists:App\Models\Classs,id'],
            'phone' => ['required'],
        ];
    }

    public function prepareForValidation($data, $index){
        if($this->extension != "csv" && $this->extension != "txt"){
            $data['dob'] = Date::excelToDateTimeObject($data['dob'])->format('Y-m-d');
        }else $data['dob']=Carbon::createFromTimestamp(strtotime($data['dob']))->toDateString();
        if(empty($data['class_id'])){
            $data['class_id'] = $data['class'];
        }
        return $data;
    }

    public function getSuccessRow() :int
    {
        return $this->rows;
    }
}
