<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class roleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('index-roles'))
            return abort(403, 'Access Denied');
        $roles = Role::all();
        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-roles'))
            return abort(403, 'Access Denied');
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function roleValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'عنوان گروه را وارد کنید'
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('create-roles'))
            return abort(403, 'Access Denied');

        $validation = $this->roleValidation($request);
        if ($validation->fails())
            return redirect()->back()->withErrors($validation, 'failed');
        $role = new role();
        $role->name = $request->name;
        $role->label = $request->name;
        $role->save();
        return redirect(route('admin.roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  role $role
     * @return \Illuminate\Http\Response
     */
    public function permissions(role $role)
    {
        if (Gate::denies('role-permissions'))
            return abort(403, 'Access Denied');
        $permissions = Permission::all();
        return view('admin.roles.permissions', [
            'permissions' => $permissions,
            'role' => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(role $role)
    {
        if (Gate::denies('edit-roles'))
            return abort(403, 'Access Denied');
        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, role $role)
    {
        if (Gate::denies('edit-roles'))
            return abort(403, 'Access Denied');
        $validator = $this->roleValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator, 'failed');
        $role->name = $request->name;
        $role->label = $request->name;
        $role->save();
        return redirect(route('admin.roles.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(role $role)
    {
        if (Gate::denies('destroy-roles'))
            return abort(403, 'Access Denied');
        $role->delete();
        return redirect(route('admin.roles.index'))->withErrors(['عملیات موفقیت آمیز بود'], 'success');
    }

    public function updatePermissions(Request $request, role $role)
    {
        if (Gate::denies('role-permissions'))
            return abort(403, 'Access Denied');
        $role->permissions()->sync($request->permission);
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
