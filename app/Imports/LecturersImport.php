<?php

namespace App\Imports;
use App\Models\Lecturer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

class LecturersImport implements ToModel,WithHeadingRow,WithValidation,SkipsOnError,SkipsOnFailure,SkipsEmptyRows
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
        return new Lecturer([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'gender' => $row['gender'],
            'title' => $row['title'],
            'degree' => $row['degree'],
            'DoB' => Carbon::createFromTimestamp(strtotime($row['dob']))->toDateString(),
            'description' => $row['description'],
            'faculty_id' => $row['faculty_id'] ?? $row['faculty'],
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
                    if(Carbon::tomorrow()->diffInYears($dob) < 22){
                        $onFailure('New Lecturers have to be more than 22 years old');
                    }
                }
            ],
            'faculty_id' => ['required','exists:App\Models\Faculty,id'],
            'title' => ['max:15'],
        ];
    }

    public function prepareForValidation($data, $index){
        if($this->extension != "csv" && $this->extension != "txt"){
            $data['dob'] = Date::excelToDateTimeObject($data['dob'])->format('Y-m-d');
        }
        if(empty($data['faculty_id'])){
            $data['faculty_id'] = $data['faculty'];
        }
        return $data;
    }

    public function getSuccessRow() :int
    {
        return $this->rows;
    }
}
