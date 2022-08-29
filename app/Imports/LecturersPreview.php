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

class LecturersPreview implements ToModel,WithHeadingRow,WithValidation,SkipsOnError,SkipsOnFailure,SkipsEmptyRows
{
    use SkipsErrors,SkipsFailures,Importable;

    public function model(array $row)
    {
        return new Lecturer([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'gender' => $row['gender'],
            'title' => $row['title'],
            'degree' => $row['degree'],
            'DoB' => Carbon::createFromTimestamp(strtotime($row['DoB']))->toDateString(),
            'description' => $row['description'],
            'faculty_id' => $row['faculty_id'] ?? $row['faculty'],
        ]);
    }


    public function rules(): array
    {
        return [
            'name' => ['required','max:30'],
            'email' => ['required','email'],
            'password' => ['required','min:8'],
            'gender' => ['required','boolean'],
            'DoB' => [
                'required',
                'date',
                function($attribute,$value,$onFailure){
                    $year = Carbon::createFromTimestamp(strtotime($value))->year();
                    if($year > Carbon::tomorrow()->year() - 22){
                        $onFailure('New Lecturers have to be more than 22 years old');
                    }
                }
            ],
            'faculty_id' => ['required','exists:App\Models\Faculty,id'],
            'title' => ['max:15'],
        ];
    }
}
