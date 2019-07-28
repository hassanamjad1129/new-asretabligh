<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('admin.home');
    }

    private function updateDashboardValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', Rule::unique('admins', 'email')->ignore(auth()->guard('admin')->user()->id)],
            'password' => ['nullable', 'min:6', 'confirmed']
        ], [
            'name.required' => 'نام و نام خانوادگی الزامیست',
            'email.required' => 'پست الکترونیکی الزامیست',
            'email.unique' => 'این ایمیل قبلا ثبت شده است',
            'password.min' => 'رمز جدید حداقل باید 6 کاراکتر باشد',
            'password.confirmed' => 'رمز عبورهای وارد شده مطابقت ندارند'
        ]);
    }

    public function updateDashboard(Request $request)
    {
        $validator = $this->updateDashboardValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        $admin = Admin::find(auth()->guard('admin')->user()->id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
