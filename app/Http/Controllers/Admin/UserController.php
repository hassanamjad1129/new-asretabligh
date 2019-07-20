<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = Customer::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.users.edit', ['customer' => $customer]);
    }

    public function validationUpdate(Request $request, Customer $customer)
    {
        return Validator::make($request->all(),
            [
                'name' => 'required',
                'telephone' => 'nullable',
                'address' => 'nullable',
                'gender' => ['required', Rule::in(['male', 'female'])],
                'avatar' => ['nullable', 'image', 'max:2048'],
                'phone' => ['required', 'regex:/(^[0][9][1-9]{9}$)/', Rule::unique('customers', 'phone')->ignore($customer->id)],
                'password' => 'same:confirmPassword',
            ], [
                'name.required' => 'نام الزامی است',
                'gender.required' => 'جنسیت الزامی است',
                'gender.in' => 'جنسیت را به درستی انتخاب کنید',
                'phone.required' => 'موبایل الزامی است',
                'phone.regex' => 'فرمت ارسالی موبایل اشتباه می باشد',
                'phone.unique' => 'شماره موبایل ارسالی قبلا ثبت شده است',
                'password.same' => 'رمز عبور با تکرار رمز عبور تطابق ندارد',
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Customer $customer
     * @return Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = $this->validationUpdate($request, $customer);
        if ($validator->fails())
            return redirect(route('admin.customer.edit', $customer))->withErrors($validator, 'failed')->withInput();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        if ($request->password)
            $customer->password = bcrypt($request->password);
        if ($request->telephone)
            $customer->telephone = $request->telephone;
        if ($request->address)
            $customer->address = $request->address;
        $customer->gender = $request->gender;
        $customer->type = ($request->type == 0) ? 'credit' : 'cash';
        if ($request->hasFile('avatar')) {
            $destinationPath = 'userAvatar'; // upload path
            $avatarExtension = $request->file('avatar')->getClientOriginalExtension(); // getting image extension
            $avatarFileName = rand(1111111111, 99999999999) . '.' . $avatarExtension; // rename image
            $request->file('avatar')->move($destinationPath, $avatarFileName); // uploading file to given path
            $customer->avatar = $destinationPath . '/' . $avatarFileName;
        }
        $customer->update();
        return redirect(route('admin.customer.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
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
