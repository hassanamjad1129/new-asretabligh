<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'categories',
                'label' => 'مدیریت دسته بندی ها'], [
                'name' => 'products',
                'label' => 'مدیریت محصولات'
            ], [
                'name' => 'papers',
                'label' => 'مدیریت کاغذها'
            ], [
                'name' => 'productPrice',
                'label' => 'قیمت محصولات'
            ], [
                'name' => 'productProperties',
                'label' => 'ویژگی های محصول'
            ], [
                'name' => 'paperProducts',
                'label' => 'مدیریت کاغذهای محصولات'
            ], [
                'name' => 'customers',
                'label' => 'مدیریت کاربران'
            ], [
                'name' => 'moneybag',
                'label' => 'مدیریت کیف پول مشتری'
            ], [
                'name' => 'customerOrders',
                'label' => 'مشاهده سفارشات یک مشتری'
            ], [
                'name' => 'orders',
                'label' => 'مشاهده سفارشات'
            ], [
                'name' => 'orderArchives',
                'label' => 'مشاهده آرشیو سفارشات'
            ], [
                'name' => 'changeOrderStatus',
                'label' => 'ویرایش وضعیت سفارش'
            ], [
                'name' => 'changeOrderQTY',
                'label' => 'تغییر سری سفارش'
            ], [
                'name' => 'changeShipping',
                'label' => 'تغییر روش یا آدرس سفارش'
            ], [
                'name' => 'posts',
                'label' => 'مدیریت پست ها'
            ], [
                'name' => 'bestCustomers',
                'label' => 'مدیریت برترین مشتریان'
            ], [
                'name' => 'slideshows',
                'label' => 'مدیریت اسلایدشوها'
            ], [
                'name' => 'shippings',
                'label' => 'مدیریت روش های ارسال'
            ], [
                'name' => 'services',
                'label' => 'مدیریت خدمات اضافی'
            ], [
                'name' => 'serviceProperties',
                'label' => 'مدیریت خدمات اضافی'
            ], [
                'name' => 'servicePrices',
                'label' => 'مدیریت قیمت خدمات اضافی'
            ], [
                'name' => 'serviceProducts',
                'label' => 'مدیریت خدمات محصولات'
            ]
        ]);
    }
}
