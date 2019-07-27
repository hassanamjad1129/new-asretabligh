<?php

namespace App\Http\Controllers\CustomerAuth;

use App\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255|unique:customers',
            'password' => 'required|min:6|confirmed',
            'phone' => ['required', Rule::unique('customers', 'phone'), 'regex:/(^[0][9][0-9]{9}$)/'],
            'telephone' => 'nullable',
            'gender' => ['required', Rule::in(['male', 'female'])]
        ], [
            'name.required' => 'وارد کردن نام الزامیست',
            'email.email' => 'پست الکترونیکی را به درستی وارد کنید',
            'email.unique' => 'این پست الکترونیکی قبلا ثبت شده است',
            'password.required' => 'وارد کردن رمز عبور الزامیست',
            'password.confirmed' => 'رمز عبور با تکرار آن مطابقت ندارد',
            'password.min' => 'رمز عبور حداقل باید 6 کاراکتر باشد',
            'phone.required' => 'وارد کردن شماره همراه الزامیست',
            'phone.unique' => 'این شماره همراه قبلا ثبت شده است',
            'phone.regex' => 'فرمت شماره همراه اشتباه است',
            'gender.required' => 'جنسیت الزامیست',
            'gender.in' => 'جنسیت را بدرستی انتخاب کنید'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Customer
     */
    protected function create(array $data)
    {
        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'telephone' => $data['telephone'],
            'gender' => $data['gender'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function showRegistrationForm()
    {
        return view('customer.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

}
