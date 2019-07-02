<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Paper;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @param Product $product
     * @return mixed
     */
    public function productPicture(Product $product)
    {
        return Storage::download($product->picture);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return Response
     */
    public function index(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();
        return view('admin.products.index', ['category' => $category, 'products' => $products]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Category $category
     * @return Response
     */
    public function create(Category $category)
    {
        //Get All Subcategories From their Category Except This Subcategory
        $allCategories = Category::all();
        return view('admin.products.create', ['category' => $category, 'allCategories' => $allCategories]);
    }

    public function productPicturePath()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $user_id = auth()->guard('admin')->user()->id;
        return "/Products/{$user_id}/{$year}/{$month}/{$day}";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateStore(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required',
            'picture' => 'required|mimes:jpg,png,jpeg,gif,svg',
            'description' => 'nullable'
        ], [
            'title.required' => 'عنوان محصول الزامی است',
            'picture.required' => 'تصویر محصول الزامی است',
            'description.required' => 'توضیحات محصول الزامی است'
        ]);
    }

    public function store(Request $request, Category $category)
    {
        $validator = $this->validateStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.products.create', [$category]))->withErrors($validator, 'failed')->withInput();
        }
        $product = new Product();
        $product->category_id = $request->category;
        $product->title = $request->title;
        $product->picture = $this->uploadFile($request->picture, $this->productPicturePath());
        $product->description = $request->description;
        $product->calculateFile = $request->calculateFile;
        $product->type = $request->type;
        $product->typeRelatedFile = $request->typeRelatedFile;
        $product->save();
        return redirect(route('admin.products.index', ['category' => $request->category]))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return void
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @param Product $product
     * @return Factory|View
     */
    public function edit(Category $category, Product $product)
    {
        //Get All Subcategories From their Category Except This Subcategory
        $allCategories = Category::all();
        return view('admin.products.edit', ['category' => $category, 'allCategories' => $allCategories, 'product' => $product]);
    }

    public function validateUpdate(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ], [
            'title.required' => 'عنوان محصول الزامی است',
            'description.required' => 'توضیحات محصول الزامی است'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @param Product $product
     * @return Response
     */
    public function update(Request $request, Category $category, Product $product)
    {
        $validator = $this->validateUpdate($request);
        if ($validator->fails()) {
            return redirect(route('admin.products.edit', [$category, $product]))->withErrors($validator, 'failed')->withInput();
        }
        $product->category_id = $request->category;
        $product->title = $request->title;
        if ($request->picture)
            $product->picture = $this->uploadFile($request->picture, $this->productPicturePath());
        $product->description = $request->description;
        $product->calculateFile = $request->calculateFile;
        $product->type = $request->type;
        $product->typeRelatedFile = $request->typeRelatedFile;
        $product->update();
        return redirect(route('admin.products.index', ['category' => $request->category]))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @param Product $product
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Category $category, Product $product)
    {
        $product->delete();
        return redirect(route('admin.products.index', ['category' => $category]))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }


    public function papers(Category $category, Product $product)
    {
        $papers = Paper::all();
        return view('admin.products.papers', ['papers' => $papers, 'product' => $product]);
    }

    public function updatePapers(Category $category, Product $product, Request $request)
    {
        $product->Papers()->sync($request->papers);
        return redirect(route('admin.products.index', ['category' => $product->category_id]))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }
}
