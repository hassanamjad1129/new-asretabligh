<?php

namespace App\Http\Controllers\Admin;

use App\pCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = pCategory::all();
        return view('admin.postCategories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = pCategory::all();
        return view('admin.postCategories.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {

        if (!$request->name)
            return back()->withErrors(['عنوان دسته بندی را وارد کنید'], 'failed')->withInput();
        $category = new pCategory();
        $category->name = $request->name;
        $category->save();
        return redirect(route('admin.pCategories.index'))->withErrors(['دسته بندی با موفقیت ثبت شد'], 'success');
    }

    public function edit(pCategory $pCategory)
    {
        $categories = pCategory::all();
        return view('admin.postCategories.edit', [
            'category' => $pCategory,
            'categories' => $categories
        ]);
    }

    public function update(pCategory $pCategory, Request $request)
    {
        if (!$request->name)
            return back()->withErrors(['عنوان دسته بندی را وارد کنید'], 'failed');
        $pCategory->name = $request->name;
        $pCategory->save();
        return redirect(route('admin.pCategories.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function destroy(pCategory $postCategory)
    {
        $postCategory->delete();
        return redirect(route('admin.pCategories.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
