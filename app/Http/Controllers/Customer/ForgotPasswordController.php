<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Services\SMSService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function forgotPasswordView()
    {
        return view('customer.auth.forgotPassword');
    }

    private function forgotPasswordValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'phone' => ['required']
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = $this->forgotPasswordValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        $customer = Customer::where('phone', $request->phone)->first();
        if ($customer) {
            $token = rand(111111, 999999);
            $smsService = new SMSService([$customer->phone]);
            $customer->password_token = $token;
            $customer->save();
            $smsService->sendPatternSMS(398, ['password' => env('APP_NAME') . "\nکد امنیتی تغییر رمز عبور : " . $token]);
            return redirect(route('customer.password.reset'))->withErrors(['کد امنیتی با موفقیت برای شما ارسال شد'], 'success');
        }
        return back()->withErrors(['خطا! چنین شماره ای در سامانه ثبت نگردیده است'], 'failed');
    }

    public function resetPasswordView()
    {
        return view('customer.auth.resetPassword');
    }

    private function resetPasswordValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'phone' => ['required'],
            'token' => ['required'],
            'password' => ['required', 'min:6', 'confirmed']
        ], [
            'phone.required' => 'شماره همراه الزامیست',
            'token.required' => 'کد امنیتی الزامیست',
            'password.required' => 'رمز عبور الزامیست',
            'password.min' => 'رمز عبور حداقل باید 6 کاراکتر باشد',
            'password.confirmed' => 'رمز عبور با تکرار آن مطابقت ندارد'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = $this->resetPasswordValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        $customer = Customer::where('phone', $request->phone)->where('password_token', $request->token)->first();
        if ($customer) {
            $customer->password = bcrypt($request->password);
            $customer->save();
            auth()->guard('customer')->loginUsingId($customer->id);
            return redirect('/customer/orders')->withErrors(['عملیات با موفقیت انجام شد'], 'success');
        }
        return back()->withErrors(['خطا! اطلاعات وارد شده صحیح نیست'], 'failed');
    }

}
