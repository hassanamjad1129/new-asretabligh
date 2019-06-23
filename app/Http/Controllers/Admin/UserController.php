<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    public function validationStore(Request $request)
    {
        return Validator::make($request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile' => ['required', 'regex:/(^[0][9][1-9]{9}$)/'],
                'password' => 'required|same:confirmPassword',
                'confirmPassword' => 'required'
            ], [
                'first_name.required' => 'نام الزامی است',
                'last_name.required' => 'نام خانوادگی الزامی است',
                'mobile.required' => 'موبایل الزامی است',
                'mobile.regex' => 'فرمت ارسالی موبایل اشتباه می باشد',
                'password.required' => 'رمز عبور الزامی است',
                'password.same' => 'رمز عبور با تکرار رمز عبور تطابق ندارد',
//                'password.min' => 'رمز عبور شما باید بیشتر از 5 حرف باشد',
                'confirmPassword.required' => 'تکرار رمز عبور الزامی است',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validationStore($request);
        if ($validator->fails())
            return redirect(route('admin.user.create'))->withErrors($validator, 'failed')->withInput();
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->password = bcrypt($request->password);
        if ($request->telephone)
            $user->telephone = $request->telephone;
        $user->type = ($request->type == 0) ? 'credit' : 'cash';
        $user->save();
        return redirect(route('admin.user.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
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
     * @param \App\User $user
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
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('admin.user.index'))->withErrors(['عملیات با موفقیت انجام شد'],'success');
    }
}
