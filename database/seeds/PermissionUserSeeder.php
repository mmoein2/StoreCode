<?php

use Illuminate\Database\Seeder;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::where('email','admin')->first();
        foreach (\App\Permission::get() as $p)
        {
            \App\PermissionUser::insert([
                'user_id'=>$user->id,
                    'permission_id'=>$p->id
                ]
            );

        }
    }
}
