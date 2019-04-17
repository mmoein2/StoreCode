<?php

namespace App\Http\Controllers;

use App\Permission;
use App\PermissionUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $permissions = Permission::get();
        return view('user.create',compact('permissions'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'password'=>'required|min:8',
            'name'=>'required',
            'email'=>'required|unique:users',
        ]);
        DB::beginTransaction();

        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $permissions=($request->permissions);
        foreach ($permissions??[] as $p)
        {
            $p =Permission::where('name_en',$p)->first();
            $pu = new PermissionUser();
            $pu->user_id = $user->id;
            $pu->permission_id = $p->id;
            $pu->save();
        }

        $user->save();

        DB::commit();
        return redirect('/user');
    }
    public function index()
    {
        $users = User::where('email','!=','admin')->latest()->paginate();
        return view('user.index',compact('users'));
    }
    public function delete(Request $request)
    {
        $usr = User::find($request->id);
        DB::beginTransaction();
        if($usr->id != auth()->id())
        {
            PermissionUser::where('user_id',$usr->id)->delete();
            $usr->delete();


        }
        DB::commit();
        return back();
    }
    public function edit(Request $request)
    {
        $user = User::find($request->id);
        if($user->email=='admin')
        {
            abort(403);
        }
        $user_permissions = PermissionUser::with('permission')->where('user_id',$user->id)->get();
        $permissions = Permission::get();
        return view('user.edit',compact('user','permissions','user_permissions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'id'=>'required',
        ]);

        $ct = User::where('email',$request->email)->count();
        if($ct>1)
        {
            return back()->withErrors(['نام کاربری قبلا انتخاب شده است']);
        }
        $user = User::where('email',$request->email)->first();
        if($user->id != $request->id)
        {
            return back()->withErrors(['نام کاربری قبلا انتخاب شده است']);
        }

        DB::beginTransaction();


        $user = User::find($request->id);
        $user->name=$request->name;
        $user->email=$request->email;
        if($request->password)
        {

        $user->password = bcrypt($request->password);
        }

        PermissionUser::where('user_id',$user->id)->delete();

        $permissions=($request->permissions);
        foreach ($permissions??[] as $p)
        {
            $p =Permission::where('name_en',$p)->first();
            $pu = new PermissionUser();
            $pu->user_id = $user->id;
            $pu->permission_id = $p->id;
            $pu->save();
        }

        $user->save();

        DB::commit();
        return redirect('/user');
    }
}
