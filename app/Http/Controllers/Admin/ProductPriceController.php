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
use Illuminate\Validation\Rule;

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
        $this->authorize('productPrice');
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
        // Sort Value of Properties
        $values = explode('-', $request->values_id);
        sort($values);
        $values = implode("-", $values);

        $productPrices = ProductPrice::where('paper_id', $request->paper)->where('values', $values)->get();
        return $productPrices;
    }

    public function ajaxRemoveProductPrice(Request $request)
    {
        $this->authorize('productPrice');
        $productPrice = ProductPrice::findOrFail($request->id);
        $productPrice->delete();
    }


    public function ajaxSubmitForm(Request $request)
    {
        $this->authorize('productPrice');
        $validator = Validator::make($request->all(), [
            'value.*' => 'required',
            'min.*' => 'required',
            'max.*' => 'required',
            'single_price.*' => 'required',
            'double_price.*' => 'required',
            'coworker_single_price.*' => 'required',
            'coworker_double_price.*' => 'required',
            'paper' => ['required', Rule::exists('papers', 'id')]

        ], [
            'value.*.required' => 'مشخصات سفارش الزامی است',
            'min.*.required' => 'تعداد حداقل الزامی است',
            'max.*.required' => 'تعداد حداکثر الزامی است',
            'single_price.*.required' => 'قیمت یک رو الزامی است',
            'double_price.*.required' => 'قیمت دو رو الزامی است',
            'coworker_single_price.*.required' => 'قیمت یک رو همکار الزامی است',
            'coworker_double_price.*.required' => 'قیمت دو رو همکار الزامی است',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if ($request->price_id)
            foreach ($request->price_id as $key => $item) {
                $productPrice = productPrice::findOrFail($request->price_id[$key]);
                $productPrice->paper_id = $request->paper;
                $productPrice->min = $request->input("min_{$item}");
                $productPrice->max = $request->input("max_{$item}");
                $productPrice->single_price = str_replace(",", "", $request->input("single_price_{$item}"));
                $productPrice->double_price = str_replace(",", "", $request->input("double_price_{$item}"));
                $productPrice->coworker_single_price = str_replace(",", "", $request->input("coworker_single_price_{$item}"));
                $productPrice->coworker_double_price = str_replace(",", "", $request->input("coworker_double_price_{$item}"));
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
                $product_price->paper_id = $request->paper;
                $product_price->product_id = $request->input('product_id')[$key];
                $product_price->min = $request->input('min')[$key];
                $product_price->max = $request->input('max')[$key];
                $product_price->single_price = str_replace(",", "", $request->input('single_price')[$key]);
                $product_price->double_price = str_replace(",", "", $request->input('double_price')[$key]);
                $product_price->coworker_single_price = str_replace(",", "", $request->input('coworker_single_price')[$key]);
                $product_price->coworker_double_price = str_replace(",", "", $request->input('coworker_double_price')[$key]);
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
}
