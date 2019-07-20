<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Customer::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function validationUpdate(Request $request)
    {
        return Validator::make($request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile' => ['required', 'regex:/(^[0][9][1-9]{9}$)/'],
                'password' => 'same:confirmPassword',
            ], [
                'first_name.required' => 'نام الزامی است',
                'last_name.required' => 'نام خانوادگی الزامی است',
                'mobile.required' => 'موبایل الزامی است',
                'mobile.regex' => 'فرمت ارسالی موبایل اشتباه می باشد',
                'password.same' => 'رمز عبور با تکرار رمز عبور تطابق ندارد',
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = $this->validationUpdate($request);
        if ($validator->fails())
            return redirect(route('admin.user.edit', $user))->withErrors($validator, 'failed')->withInput();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        if ($request->password)
            $user->password = bcrypt($request->password);
        if ($request->telephone)
            $user->telephone = $request->telephone;
        $user->type = ($request->type == 0) ? 'credit' : 'cash';
        $user->update();
        return redirect(route('admin.user.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect(route('admin.user.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
