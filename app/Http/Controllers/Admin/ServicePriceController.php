<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductProperty;
use App\Models\ProductValue;
use App\Models\Subcategory;
use App\Service;
use App\ServicePrice;
use App\ServiceProperty;
use App\ServiceValue;
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

class ServicePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Service $service
     * @return Response
     */
    public function create(Service $service)
    {
        $serviceProperties = $service->ServiceProperties()->where('value_id', null)->get();
        return view('admin.services.prices.create', ['service' => $service, 'serviceProperties' => $serviceProperties]);
    }

    public function ajaxServiceProperties(Request $request)
    {
        $properties = ServiceProperty::where('value_id', $request->value_id)->get();
        return $properties;
    }

    public function ajaxServiceAnswers(Request $request)
    {
        $Answers = ServiceValue::where('property_id', $request->property_id)->get();
        return $Answers;
    }

    public function ajaxServicePrices(Request $request)
    {
        $productPrices = ServicePrice::where('values', $request->values_id)->get();
        return $productPrices;
    }

    public function ajaxRemoveServicePrice(Request $request)
    {
        $servicePrice = ServicePrice::findOrFail($request->id);
        $servicePrice->delete();
    }


    public function ajaxSubmitForm(Request $request)
    {
        $service = Service::find($request->service);
        $validator = Validator::make($request->all(), [
            'value.*' => 'required',
            'min.*' => 'required',
            'max.*' => 'required',
        ], [
            'value.*.required' => 'مشخصات سفارش الزامی است',
            'min.*.required' => 'تعداد حداقل الزامی است',
            'max.*.required' => 'تعداد حداکثر الزامی است',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if ($request->price_id)
            foreach ($request->price_id as $key => $item) {
                $servicePrice = ServicePrice::findOrFail($request->price_id[$key]);
                $servicePrice->min = $request->input("min_{$item}");
                $servicePrice->max = $request->input("max_{$item}");
                if ($servicePrice->service->allow_type) {
                    $servicePrice->single_price = str_replace(",", "", $request->input("single_price_{$item}"));
                    $servicePrice->double_price = str_replace(",", "", $request->input("double_price_{$item}"));
                    $servicePrice->coworker_single_price = str_replace(",", "", $request->input("coworker_single_price_{$item}"));
                    $servicePrice->coworker_double_price = str_replace(",", "", $request->input("coworker_double_price_{$item}"));
                    $servicePrice->update();
                } else {
                    $servicePrice->price = str_replace(",", "", $request->input("price_{$item}"));
                    $servicePrice->coworker_price = str_replace(",", "", $request->input("coworker_price_{$item}"));
                    $servicePrice->update();
                }
            }
        $values = [];
        foreach ($request->value as $key => $item) {
            array_push($values, (int)$item);
        }
        $val = collect($values)->sort();
        $value_id = implode("-", $val->values()->all());
        if ($request->min)
            foreach ($request->min as $key => $value) {
                $service_price = new ServicePrice();
                $service_price->service_id = $service->id;
                $service_price->min = $request->input('min')[$key];
                $service_price->max = $request->input('max')[$key];
                if ($service->allow_type) {
                    $service_price->single_price = str_replace(",", "", $request->input('single_price')[$key]);
                    $service_price->double_price = str_replace(",", "", $request->input('double_price')[$key]);
                    $service_price->coworker_single_price = str_replace(",", "", $request->input('coworker_single_price')[$key]);
                    $service_price->coworker_double_price = str_replace(",", "", $request->input('coworker_double_price')[$key]);
                } else {
                    $service_price->price = str_replace(",", "", $request->input('price')[$key]);
                    $service_price->coworker_price = str_replace(",", "", $request->input('coworker_price')[$key]);
                }
                $service_price->values = $value_id;
                $service_price->save();
            }
        return response()->json(['success' => 'Record is successfully added']);
    }
}
