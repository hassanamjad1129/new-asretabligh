<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            [
                'option_name' => 'address',
                'option_value' => 'تهران بلوار کشاورز',
                'label' => 'آدرس چاپخانه'
            ],
            [
                'option_name' => 'email',
                'option_value' => 'info@asretabligh.com',
                'label' => 'ایمیل چاپخانه'
            ], [
                'option_name' => 'phone',
                'option_value' => '021 00 00 00 00',
                'label' => 'شماره تلفن چاپخانه'
            ], [
                'option_name' => 'property',
                'option_value' => '',
                'label' => 'ویژگی های چاپخانه'
            ],
        ]);
    }
}
