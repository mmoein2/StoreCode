<?php

namespace App\Imports;

use App\SubCode;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubCodeImport implements ToModel,WithValidation,WithHeadingRow
{
    use Importable;

    public $day=0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SubCode([
            'code'=>$row['code'],
            'serial'=>$row['serial'],
            'score'=>$row['score'],
            'expiration_day' =>$this->day,
        ]);
    }
    public function __construct($day)
    {
        $this->day=$day;
    }
    public function rules(): array
    {
        return [
            'code' => 'required',
            'code' => 'unique:sub_codes',
            'serial' =>'required|numeric|unique:main_codes',
            'score'  => 'required|numeric'
        ];
    }

}
