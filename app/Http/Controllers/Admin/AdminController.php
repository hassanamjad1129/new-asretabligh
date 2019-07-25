<?php

namespace App\Http\Controllers\Admin;

use App\admin;
use App\Role;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private function createValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', Rule::unique('admins', 'id')],
            'password' => ['required', 'min:6', 'confirmed']
        ]);
    }

    private function editValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', Rule::unique('admins', 'id')],
            'password' => ['nullable', 'min:6', 'confirmed']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $admins = Admin::where('level', 'normal')->get();
        return view('admin.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = $this->createValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();
        return redirect(route('admin.admins.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param admin $admin
     * @return Response
     */
    public function edit(admin $admin)
    {
        return view('admin.admins.edit', ['admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param admin $admin
     * @return Response
     */
    public function update(Request $request, admin $admin)
    {
        $validator = $this->editValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->all(), 'failed');
        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->password)
            $admin->password = bcrypt($request->password);
        $admin->save();
        return redirect(route('admin.admins.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param admin $admin
     * @return Response
     * @throws Exception
     */
    public function destroy(admin $admin)
    {
        $admin->delete();
        return redirect(route('admin.admins.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function roles(Admin $admin)
    {
        if (Gate::denies('updateRole-admins'))
            return abort(403, 'Access Denied');
        $this->checkSuperUser($admin);
        $roles = Role::all();
        return view('admin.admins.roles', [
            'roles' => $roles,
            'admin' => $admin
        ]);
    }

    private function checkSuperUser(Admin $admin)
    {
        if ($admin->isSuperUser())
            return back()->withErrors(['داده نامعتبر'], 'failed');
    }

    public function updateRoles(Request $request, Admin $admin)
    {
        if (Gate::denies('updateRole-admins'))
            return abort(403, 'Access Denied');
        $this->checkSuperUser($admin);
        $admin->roles()->sync($request->role);
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

}
