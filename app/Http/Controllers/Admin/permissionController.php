<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class permissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('index-permission'))
            return abort(403, 'Access Denied');

        $permissions = permission::all();
        return view('admin.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    private function permissionValidation(Request $request)
    {

        return Validator::make($request->all(), [
            'name' => 'required',
            'label' => 'required'
        ], [
            'name.required' => 'نام دسترسی را وارد کنید',
            'label.required' => 'عنوان دسترسی را وارد کنید'
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-permission'))
            return abort(403, 'Access Denied');
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        if (Gate::denies('create-permission'))
            return abort(403, 'Access Denied');

        $validator = $this->permissionValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator, 'failed')->withInput();
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->label = $request->label;
        $permission->save();
        return redirect(route('admin.permissions.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        if (Gate::denies('edit-permission'))
            return abort(403, 'Access Denied');

        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, permission $permission)
    {
        if (Gate::denies('edit-permission'))
            return abort(403, 'Access Denied');

        $validation = $this->permissionValidation($request);
        if ($validation->fails())
            return back()->withErrors($validation, 'failed')->withInput();
        $permission->name = $request->name;
        $permission->label = $request->label;
        $permission->save();
        return redirect(route('admin.permissions.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
