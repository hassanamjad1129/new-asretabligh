<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductProperty;
use App\Models\ProductValue;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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

class ProductPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Product $product
     * @return Response
     */
    public function index(Product $product)
    {
        $this->authorize('productProperties');

        $category = $product->category;

        $productProperties = $product->ProductProperties;
        return view('admin.productProperties.index', ['productProperties' => $productProperties, 'product' => $product, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create(Product $product)
    {
        $this->authorize('productProperties');
        $productProperties = $product->ProductProperties()->get();
        return view('admin.productProperties.create', ['product' => $product, 'productProperties' => $productProperties]);
    }

    public function productPropertiesPicturePath()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $user_id = auth()->guard('admin')->user()->id;
        return "/ProductProperties/{$user_id}/{$year}/{$month}/{$day}";
    }

    public function validateStore(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
        ], [
            'name.required' => 'عنوان مشخصه الزامی است',
            'description.required' => 'توضیحات مشخصه الزامی است',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('productProperties');
        $validator = $this->validateStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.productProperties.create', [$product]))->withErrors($validator, 'failed')->withInput();
        }
        if ($request->type == 2) {
            $flagIsNull = false;
            if ($request->answer) {
                foreach ($request->answer as $key => $value) {
                    if ($value == null) {
                        $flagIsNull = true;
                        break;
                    }
                }
                if ($flagIsNull == true) {
                    return redirect(route('admin.productProperties.create', [$product]))->withErrors('پر کردن تمامی فیلد ها برای پاسخ های مشخصه الزامی است ', 'failed')->withInput();
                } else {
                    $productProperties = new ProductProperty();
                    $productProperties->name = $request->name;
                    $productProperties->type = 'selectable';
                    $productProperties->description = $request->description;
                    $productProperties->product_id = $product->id;
                    if ($request->dependency != 0)
                        $productProperties->value_id = $request->dependency;
                    $productProperties->save();
                    foreach ($request->answer as $key => $value) {
                        $productValues = new ProductValue();
                        $productValues->name = $value;
                        $productValues->property_id = $productProperties->id;
                        $productValues->save();
                    }
                    $productAnswers = $productProperties->ProductValues()->get();
                    if ($request->picture)
                        foreach ($request->picture as $key => $picture) {
                            if ($picture) {
                                $productAnswers[$key]->picture = $this->uploadFile($picture, $this->productPropertiesPicturePath());
                                $productAnswers[$key]->update();
                            }
                        }
                    return redirect(route('admin.productProperties.index', [$product]))->withErrors('عملیات با موفقیت انجام شد', 'success');
                }
            } else {
                return redirect(route('admin.productProperties.create', [$product]))->withErrors(['پاسخ های مشخصه الزامی است'], 'failed')->withInput();
            }
        }
        $productProperty = new ProductProperty();
        $productProperty->name = $request->name;
        $productProperty->type = 'input';
        $productProperty->description = $request->description;
        $productProperty->product_id = $product->id;
        $productProperty->save();
        return redirect(route('admin.productProperties.index', [$product]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function ProductAnswer(ProductValue $productAnswer)
    {
        return Storage::download($productAnswer->picture);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @param ProductProperty $productProperty
     * @return Factory|View
     * @throws AuthorizationException
     */


    public function edit(Product $product, ProductProperty $productProperty)
    {
        $this->authorize('productProperties');
        $productProperties = $product->ProductProperties()->where('id', '<>', $productProperty->id)->get();
        $productAnswers = $productProperty->ProductValues()->get();
        return view('admin.productProperties.edit', ['product' => $product, 'productProperty' => $productProperty, 'productAnswers' => $productAnswers, 'productProperties' => $productProperties]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param ProductProperty $productProperty
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Product $product, ProductProperty $productProperty)
    {
        $this->authorize('productProperties');
        $validator = $this->validateStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.productProperties.edit', [$product, $productProperty]))->withErrors($validator, 'failed')->withInput();
        }
        if ($productProperty->type == 'selectable') {
            $flagIsNull = false;
            $productValues = $productProperty->ProductValues()->get();
            foreach ($productValues as $productValue) {
                if ($request->input('answer_' . $productValue->id) == null) {
                    $flagIsNull = true;
                    break;
                }
            }
            if ($request->answer)
                foreach ($request->answer as $key => $value) {
                    if ($value == null) {
                        $flagIsNull = true;
                        break;
                    }
                }
            if ($flagIsNull == true) {
                return redirect(route('admin.productProperties.edit', [$product, $productProperty]))->withErrors(['پر کردن تمامی فیلد ها برای پاسخ های مشخصه الزامی است '], 'failed')->withInput();
            } else {
                $productProperty->name = $request->name;
                $productProperty->description = $request->description;
                if ($request->dependency != 0) {
                    if (ProductValue::find($request->dependency)->property_id == $productProperty->id)
                        return redirect(route('admin.productProperties.edit', [$product, $productProperty]))->withErrors(['وابسته سازی به پاسخ های مشخصه این مشخصه امکان پذیر نیست'], 'failed')->withInput();
                    $productProperty->value_id = $request->dependency;
                }
                $productProperty->update();
                if ($request->answer)
                    foreach ($request->answer as $value) {
                        $productValue = new ProductValue();
                        $productValue->name = $value;
                        $productValue->property_id = $productProperty->id;
                        $productValue->save();
                    }
                foreach ($productValues as $item) {
                    $item->name = $request->input('answer_' . $item->id);
                    $item->update();
                }
                $productAnswers = $productProperty->ProductValues()->get();
                if ($request->picture)
                    foreach ($request->picture as $key => $picture) {
                        if ($picture) {
                            $productAnswers[$key]->picture = $this->uploadFile($picture, $this->productPropertiesPicturePath());
                            $productAnswers[$key]->update();
                        }
                    }
                return redirect(route('admin.productProperties.index', [$product]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
            }
        }
        $productProperty->name = $request->name;
        $productProperty->description = $request->description;
        $productProperty->update();
        return redirect(route('admin.productProperties.index', [$product]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * @param Product $product
     * @param ProductProperty $productProperty
     * @param ProductValue $productValue
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroyValue(Product $product, ProductProperty $productProperty, productValue $productValue)
    {
        $this->authorize('productProperties');
        if ($productProperty->ProductValues()->get()->count() == 1)
            return redirect(route('admin.productProperties.edit', [$product, $productProperty]))->withErrors(['وجود حداقل یک پاسخ مشخصه الزامی میباشد'], 'failed');
        $productValue->delete();
        return redirect(route('admin.productProperties.edit', [$product, $productProperty]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param ProductProperty $productProperty
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Product $product, ProductProperty $productProperty)
    {
        $this->authorize('productProperties');
        $productValues = $productProperty->ProductValues()->get();
        foreach ($productValues as $key => $item) {
            $item->delete();
        }
        $productProperty->delete();
        return redirect(route('admin.productProperties.index', [$product]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
