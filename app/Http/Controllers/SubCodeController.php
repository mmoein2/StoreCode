<?php

namespace App\Http\Controllers;

use App\Imports\SubCodeImport;
use App\SubCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubCodeController extends Controller
{
    public function index()
    {
        return view('subcode.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'file'=>'required'
        ]);
        $file = $request->file('file');

        Excel::import(new SubCodeImport, $file);
        return back()->with('message','کدهای فرعی با موفقیت ایجاد شدند');
    }
}
