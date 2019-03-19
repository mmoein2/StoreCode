<?php

namespace App\Http\Controllers;

use App\Prize;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    public function index()
    {
        $prizes = Prize::paginate();
        return view('prize.index',compact('prizes'));
    }
    public function create()
    {
        return view('prize.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'score'=>'required|numeric',
        ]);
        $p = new Prize($request->all());
        $p->save();

        return redirect('/prize');
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        $prize =Prize::find($id);
        return view('prize.edit',compact('prize'));

    }
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'score'=>'required|numeric',
        ]);
        $p = Prize::find($request->id);
        $p->score=$request->score;
        $p->name=$request->name;
        $p->save();
        return redirect('/prize');


    }
    public function delete(Request $request)
    {
        try
        {
            Prize::destroy($request->id);

        }catch(\Exception $ex)
        {
            return back()->withErrors(['امکان حذف وجود ندارد']);

        }
        return back();
    }
}
