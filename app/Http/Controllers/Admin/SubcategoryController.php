<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Subcategory;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return Factory|View
     */
    public function index(Category $category)
    {
        $subcategories = Subcategory::where('category_id', $category->id)->get();
        return view('admin.subcategories.index', ['category' => $category, 'subcategories' => $subcategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Category $category
     * @return Response
     */
    public function create(Category $category)
    {
        //Get All Categories Except This Category
        $allCategories = Category::where('id', '!=', $category->id)->get();
        return view('admin.subcategories.create', ['category' => $category, 'allCategories' => $allCategories]);
    }

    public function subcategoryPicture(Subcategory $subcategory)
    {
        return Storage::download($subcategory->picture);
    }

    public function subcategoriesPicturePath()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $user_id = auth()->guard('admin')->user()->id;
        return "/Subcategories/{$user_id}/{$year}/{$month}/{$day}";
    }

    public function validationStore(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'picture' => 'required|mimes:jpg,png,jpeg,gif,svg',
            'description' => 'required'
        ], [
            'name.required' => 'عنوان زیر دسته الزامی است',
            'picture.required' => 'تصویر زیر دسته الزامی است',
            'description' => 'توضیحات زیر دسته الزامی است'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return Response
     */
    public function store(Request $request, Category $category)
    {
        $validator = $this->validationStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.subcategories.create', [$category]))->withErrors($validator, 'failed')->withInput();
        }
        $subcategory = new Subcategory();
        $subcategory->category_id = $request->parent;
        $subcategory->name = $request->name;
        $subcategory->picture = $this->uploadFile($request->picture, $this->subcategoriesPicturePath());
        $subcategory->description = $request->description;
        $category = Category::find($request->parent);
        $subcategory->save();
        return redirect(route('admin.subcategories.index', ['category' => $category]))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Subcategory $subcategory
     * @return Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @param \App\Subcategory $subcategory
     * @return Response
     */
    public function edit(Category $category, Subcategory $subcategory)
    {
        //Get All Categories Except This Category
        $allCategories = Category::where('id', '!=', $category->id)->get();
        return view('admin.subcategories.edit', ['category' => $category, 'subcategory' => $subcategory, 'allCategories' => $allCategories]);
    }

    public function validationUpdate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ], [
            'name.required' => 'عنوان زیر دسته الزامی است',
            'description' => 'توضیحات زیر دسته الزامی است'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Category $category
     * @param \App\Subcategory $subcategory
     * @return Response
     */
    public function update(Request $request, Category $category, Subcategory $subcategory)
    {
        $validator = $this->validationUpdate($request);
        if ($validator->fails()) {
            return redirect(route('admin.subcategories.create', [$category]))->withErrors($validator, 'failed')->withInput();
        }
        $subcategory->category_id = $request->parent;
        $subcategory->name = $request->name;
        if ($request->picture)
            $subcategory->picture = $this->uploadFile($request->picture, $this->subcategoriesPicturePath());
        $subcategory->description = $request->description;
        $category = Category::find($request->parent);
        $subcategory->update();
        return redirect(route('admin.subcategories.index', ['category' => $category]))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @param \App\Subcategory $subcategory
     * @return Response
     * @throws \Exception
     */
    public function destroy(Category $category, Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect(route('admin.subcategories.index', ['category' => $category]))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }
}
