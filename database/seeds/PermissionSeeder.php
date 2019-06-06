<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\Permission::insert([
//            [
//                'name_fa'=>'دسترسی به کدهای فرعی',
//                'name_en' =>'subcode'
//            ],
//            [
//                'name_fa'=>'دسترسی به کدهای اصلی',
//                'name_en' =>'maincode'
//            ],
//            [
//                'name_fa'=>'دسترسی به فروشگاه',
//                'name_en' =>'shop'
//            ],
//            [
//                'name_fa'=>'دسترسی به مشتریان',
//                'name_en' =>'customer'
//            ],
//            [
//                'name_fa'=>'دسترسی به جوایز',
//                'name_en' =>'prize'
//            ],
//            [
//                'name_fa'=>'دسترسی به نمودار',
//                'name_en' =>'chart'
//            ],
//            [
//                'name_fa'=>'دسترسی به پیام های فروشگاه',
//                'name_en' =>'shop-support'
//            ],
//            [
//                'name_fa'=>'دسترسی به پشتیبانی کاربران',
//                'name_en' =>'customer-support'
//            ],
//            [
//                'name_fa'=>'دسترسی به اسلایدر',
//                'name_en' =>'slider'
//            ],
//            [
//                'name_fa'=>'دسترسی به مبلغ پست ویژه',
//                'name_en' =>'special-post'
//            ],
//            [
//                'name_fa'=>'دسترسی به تغییر رمز عبور سایت',
//                'name_en' =>'change-password'
//            ],
//            [
//                'name_fa'=>'دسترسی به ایجاد کاربر سایت',
//                'name_en' =>'insert-user'
//            ],
//            [
//                'name_fa'=>'دسترسی به ویرایش کدهای فرعی',
//                'name_en' =>'edit-subcode'
//            ],
//            [
//                'name_fa'=>'دسترسی به حذف کدهای فرعی',
//                'name_en' =>'delete-subcode'
//            ],
//            [
//                'name_fa'=>'دسترسی به ویرایش کدهای اصلی',
//                'name_en' =>'edit-maincode'
//            ],
//
//            [
//                'name_fa'=>'دسترسی به حذف کدهای اصلی',
//                'name_en' =>'delete-maincode'
//            ],
//        ]);
//        \App\Permission::insert([
//            'name_fa'=>'بروزرسانی',
//            'name_en'=>'update',
//        ]);
        \App\Permission::insert([
            'name_fa'=>'دسترسی به ویرایش فروشگاه',
            'name_en'=>'edit-shop',
        ]);
    }
}
