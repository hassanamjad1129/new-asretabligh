<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('categories');
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('categories');
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validationStore(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'picture' => 'required|mimes:jpg,png,jpeg,gif,svg',
        ], [
            'name.required' => 'عنوان دسته بندی الزامی است',
            'picture.required' => 'تصویر دسته بندی الزامی است',
        ]);

    }

    public function categoriesPicturePath()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $user_id = auth()->guard('admin')->user()->id;
        return "/Categories/{$user_id}/{$year}/{$month}/{$day}";
    }

    public function store(Request $request)
    {
        $this->authorize('categories');
        $validator = $this->validationStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.categories.create'))->withErrors($validator, 'failed')->withInput();
        }
        $category = new Category();
        $category->status = ($request->status == "on") ? 1 : 0;
        $category->name = $request->name;
        $category->count_paper = $request->count_pages == "yes" ? true : false;
        $category->picture = $this->uploadFile($request->picture, $this->categoriesPicturePath());
        $category->description = $request->description;
        $category->save();
        return redirect(route('admin.categories.index'))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    public function categoryPicture(Category $category)
    {
        return Storage::download($category->picture);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Category $category
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Category $category)
    {
        $this->authorize('categories');
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function validationUpdate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'عنوان دسته بندی الزامی است'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('categories');
        $validator = $this->validationUpdate($request);
        if ($validator->fails()) {
            return redirect(route('admin.categories.create'))->withErrors($validator, 'failed')->withInput();
        }
        $category->status = ($request->status == "on") ? 1 : 0;
        $category->name = $request->name;
        $category->count_paper = $request->count_paper;
        if ($request->picture)
            $category->picture = $this->uploadFile($request->picture, $this->categoriesPicturePath());
        if ($request->description)
            $category->description = $request->description;
        $category->update();
        return redirect(route('admin.categories.index'))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $this->authorize('categories');
        $category->delete();
        return redirect(route('admin.categories.index'))->withErrors('عملیات با موفقیت انجام شد', 'failed');
    }
}
