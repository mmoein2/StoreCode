<?php

namespace App\Imports;

use App\MainCode;
use App\Prize;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MainCodeImport implements ToModel,WithHeadingRow,WithValidation
{
    private $day=0;
    public $errors=[];
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $errors=[];
        $prize = Prize::where('name',$row['type'])->first();
        if($prize==null)
        {
            $this->errors[]="نوع جایزه ". $row['type']. " در سیستم وجود ندارد";
            return;
        }
        return new MainCode([
            'code'=>$row['code'],
            'serial'=>$row['serial'],
            'prize_id' =>$prize->id,
            'expiration_day'=>$this->day
        ]);
    }
    public function __construct($day)
    {
        $this->day=$day;
    }
    public function rules(): array
    {
        return [
            'code' => Rule::unique('main_codes','code'),
        ];
    }
}
