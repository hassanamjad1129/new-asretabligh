<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Morilog\Jalali\CalendarUtils;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('customers');

        $users = Customer::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Customer $customer)
    {
        $this->authorize('customers');

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
                'price' => ['required', Rule::in(['normal', 'coworker'])],
                'phone' => ['required', 'regex:/(^[0][9][0-9]{9}$)/', Rule::unique('customers', 'phone')->ignore($customer->id)],
                'password' => 'same:confirmPassword',
            ], [
                'name.required' => 'نام الزامی است',
                'gender.required' => 'جنسیت الزامی است',
                'gender.in' => 'جنسیت را به درستی انتخاب کنید',
                'price.required' => 'نوع محاسبه قیمت الزامی است',
                'price.in' => 'نوع محاسبه قیمت را به درستی انتخاب کنید',
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
     * @throws AuthorizationException
     */
    public function update(Request $request, Customer $customer)
    {
        $this->authorize('customers');
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
        $customer->price = $request->price;
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
        $this->authorize('customers');
        $customer->delete();
        return redirect(route('admin.user.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function orders(Customer $customer)
    {
        $this->authorize('customerOrders');
        $orders = $customer->orderItems()->where('status', '>', 0)->latest()->get();
        return view('admin.users.orders', ['orders' => $orders]);
    }

    public function filterOrders(Customer $customer, Request $request)
    {
        $this->authorize('customerOrders');
        $orders = $customer->orderItems()->where('status', '>', 0);

        if ($request->has('start_date')) {
            $startTime = CalendarUtils::createCarbonFromFormat('Y/m/d', $request->start_date)->toDateTimeString();
            $orders = $orders->where('created_at', '>=', $startTime);
        }
        if ($request->has('finish_date')) {
            $finishTime = CalendarUtils::createCarbonFromFormat('Y/m/d', $request->finish_date)->addDays(1)->toDateTimeString();
            $orders = $orders->where('created_at', '<', $finishTime);
        }
        $orders = $orders->latest()->get();
        return view('admin.users.orders', ['orders' => $orders]);
    }
}
