<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function changePasswordShow()
    {
        return view('user.changePassword');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
           'password'=>'required|min:8'
        ]);

            $usr = auth()->user();
            $usr->password = bcrypt($request->password);
            $usr->save();
            return back()->with(['message'=>'رمز عبور با موفقیت تغییر یافت']);
    }
    public function create()
    {
        $roles = Role::get();
        return view('user.create',compact('roles'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'password'=>'required|min:8',
            'name'=>'required',
            'email'=>'required',
            'role_id'=>'required|numeric',
        ]);
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        return back();
    }
    public function index()
    {
        $users = User::with('role')->where('email','!=','admin')->latest()->paginate();
        return view('user.index',compact('users'));
    }
    public function delete(Request $request)
    {
        $usr = User::find($request->id);
        if($usr->id != auth()->id())
        {
            $usr->delete();

        }
        return back();
    }
}
