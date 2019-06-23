<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductProperty;
use App\Models\ProductValue;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Category $category
     * @param Subcategory $subcategory
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category, Subcategory $subcategory, Product $product)
    {
        $productProperties = $product->ProductProperties()->where('value_id', null)->get();
        return view('admin.productPrices.create', ['category' => $category, 'subcategory' => $subcategory, 'product' => $product, 'productProperties' => $productProperties]);
    }

    public function ajaxProductProperties(Request $request)
    {
        $properties = ProductProperty::where('value_id', $request->value_id)->get();
        return $properties;
    }

    public function ajaxProductAnswers(Request $request)
    {
        $Answers = ProductValue::where('property_id', $request->property_id)->get();
        return $Answers;
    }

    public function ajaxProductPrices(Request $request)
    {
        $productPrices = ProductPrice::where('values', $request->values_id)->get();
        return $productPrices;
    }

    public function ajaxRemoveProductPrice(Request $request)
    {
        $productPrice = ProductPrice::findOrFail($request->id);
        $productPrice->delete();
    }


    public function ajaxSubmitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value.*' => 'required',
            'min.*' => 'required',
            'max.*' => 'required',
            'single_price.*' => 'required',
            'double_price.*' => 'required'
        ], [
            'value.*.required' => 'مشخصات سفارش الزامی است',
            'min.*.required' => 'تعداد حداقل الزامی است',
            'max.*.required' => 'تعداد حداکثر الزامی است',
            'single_price.*.required' => 'قیمت یک رو الزامی است',
            'double_price.*.required' => 'قیمت دو رو الزامی است',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if ($request->price_id)
            foreach ($request->price_id as $key => $item) {
                $productPrice = productPrice::findOrFail($request->price_id[$key]);
                $productPrice->min = $request->input("min_{$item}");
                $productPrice->max = $request->input("max_{$item}");
                $productPrice->single_price = str_replace(",", "", $request->input("single_price_{$item}"));
                $productPrice->double_price = str_replace(",", "", $request->input("double_price_{$item}"));
                $productPrice->update();
            }
        $values = [];
        foreach ($request->value as $key => $item) {
            array_push($values, (int)$item);
        }
        $val = collect($values)->sort();
        $value_id = implode("-", $val->values()->all());
        if ($request->min)
            foreach ($request->min as $key => $value) {
                $product_price = new ProductPrice();
                $product_price->product_id = $request->input('product_id')[$key];
                $product_price->min = $request->input('min')[$key];
                $product_price->max = $request->input('max')[$key];
                $product_price->single_price = str_replace(",", "", $request->input('single_price')[$key]);
                $product_price->double_price = str_replace(",", "", $request->input('double_price')[$key]);
                $product_price->values = $value_id;
                $product_price->save();
            }
        return response()->json(['success' => 'Record is successfully added']);
    }

    public function ValidationStore(Request $request)
    {
        return Validator::make($request->all(), [
            'min' => 'required',
            'max' => 'required',
            'price' => 'required',
        ], [
            'min.required' => 'تعداد حداقل الزامی است',
            'max.required' => 'تعداد حداکثر الزامی است',
            'price' => 'قیمت الزامی است'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @param Subcategory $subcategory
     * @param Product $product
     * @return void
     */
    public function store(Request $request, Category $category, Subcategory $subcategory, Product $product)
    {
        $validator = $this->ValidationStore($request);
        if ($validator->fails())
            return redirect(route('admin.productPrice.create', ['category' => $category, 'subcategory' => $subcategory, 'product' => $product]))->withErrors([$validator], 'failed')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ProductPrice $productPrice
     * @return \Illuminate\Http\Response
     */
    public function show(ProductPrice $productPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ProductPrice $productPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPrice $productPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ProductPrice $productPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPrice $productPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ProductPrice $productPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPrice $productPrice)
    {
        //
    }
}
