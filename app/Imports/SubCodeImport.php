<?php

namespace App\Imports;

use App\SubCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubCodeImport implements ToModel,WithHeadingRow
{
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
        ]);
    }
}
