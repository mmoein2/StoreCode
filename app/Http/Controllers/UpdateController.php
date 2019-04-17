<?php

namespace App\Http\Controllers;

use App\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function index()
    {
        $updates = Update::latest()->paginate(10);
        return view('update.index',compact('updates'));
    }
    public function create()
    {
        return view('update.create');

    }
    public function store(Request $request)
    {
        $request->validate([
            "version_name"=>"required|unique:updates",
            "version_code"=>"numeric|required|unique:updates",
            "link"=>"required",

        ]);
        $update = new Update();
        $update->version_name=$request->version_name;
        $update->version_code=intval($request->version_code);
        $update->link=  ($request->link);
        if($request->new_features)
        {
            $update->new_features=($request->new_features);

        }
        else
        {
            $update->new_features="";

        }
        $update->save();
        return redirect('/update');



    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $data = Update::where('id',intval($id))->first();
        $data->delete();
        return back();
    }
}
