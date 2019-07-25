<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('customer.home');
    }

    public function updateProfileValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', Rule::unique('customers', 'email')->ignore(auth()->guard('customer')->user()->id)],
            'telephone' => ['nullable'],
            'address' => ['nullable'],
            'avatar' => ['nullable', 'image', 'max:2048']
        ], [
            'name.required' => 'نام و نام خانوادگی الزامیست',
            'email.required' => 'پست الکترونیکی الزامیست',
            'email.unique' => 'این پست الکترونیکی قبلا ثبت شده است',
            'avatar.image' => 'فرمت فایل ارسالی نامعتبر است',
            'avatar.max' => 'سایز تصویر حداکثر باید 2 مگ باشد'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validator = $this->updateProfileValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed')->withInput();
        $customer = Customer::find(auth()->guard('customer')->user()->id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->telephone = $request->telephone;
        $customer->address = $request->address;
        if ($request->hasFile('avatar')) {
            $destinationPath = 'userAvatar'; // upload path
            $avatarExtension = $request->file('avatar')->getClientOriginalExtension(); // getting image extension
            $avatarFileName = rand(11111111, 999999999) . '.' . $avatarExtension; // rename image
            $request->file('avatar')->move($destinationPath, $avatarFileName); // uploading file to given path
            $customer->avatar = $destinationPath . '/' . $avatarFileName;
        }
        $customer->save();
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
