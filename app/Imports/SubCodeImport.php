<?php

namespace App\Imports;

use App\SubCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubCodeImport implements ToModel,WithHeadingRow
{
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
}
