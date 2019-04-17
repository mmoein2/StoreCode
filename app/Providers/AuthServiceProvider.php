<?php

namespace App\Providers;

use App\Permission;
use App\PermissionUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('subcode',function ($user){
            $id = Permission::where('name_en','subcode')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('maincode',function ($user){
            $id = Permission::where('name_en','maincode')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('shop',function ($user){
            $id = Permission::where('name_en','shop')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('customer',function ($user){
            $id = Permission::where('name_en','customer')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('prize',function ($user){
            $id = Permission::where('name_en','prize')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('chart',function ($user){
            $id = Permission::where('name_en','chart')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('shop-support',function ($user){
            $id = Permission::where('name_en','shop-support')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('customer-support',function ($user){
            $id = Permission::where('name_en','customer-support')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('slider',function ($user){
            $id = Permission::where('name_en','slider')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('special-post',function ($user){
            $id = Permission::where('name_en','special-post')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('change-password',function ($user){
            $id = Permission::where('name_en','change-password')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('insert-user',function ($user){
            $id = Permission::where('name_en','insert-user')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('edit-subcode',function ($user){
            $id = Permission::where('name_en','edit-subcode')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('delete-subcode',function ($user){
            $id = Permission::where('name_en','delete-subcode')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('edit-maincode',function ($user){
            $id = Permission::where('name_en','edit-maincode')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
        Gate::define('delete-maincode',function ($user){
            $id = Permission::where('name_en','delete-maincode')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });

        Gate::define('update',function ($user){
            $id = Permission::where('name_en','update')->first()->id;
            return PermissionUser::where('user_id',$user->id)
                ->where('permission_id',$id)->exists();
        });
    }
}
