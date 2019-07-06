<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\ProductPrice;
use App\ServicePrice;
use App\ServiceProperty;
use Howtomakeaturn\PDFInfo\PDFInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ATCart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkFiles(Request $request)
    {
        $pageCount = 0;
        $this->validate($request, [
            'back-file' => 'nullable|mimes:jpeg,jpg,pdf|max:51200',
            'front-file' => 'nullable|mimes:jpeg,jpg,pdf|max:51200',
        ]);

        foreach ($request->allFiles() as $key => $item) {
            if ($item and $key != 'product') {
                $destinationPath = 'orderFiles'; // upload path
                $extension = $item->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111, 99999) . '.' . $extension; // rename image
                $item->move($destinationPath, $fileName); // uploading file to given path
                $request->session()->put('file.' . $request->product . '.' . $key, $fileName);
                if ($extension != 'pdf') {
                    $pageCount++;
                    continue;
                }
                $pdf = new PDFInfo(public_path('/orderFiles/' . $fileName));
                $pageCount += $pdf->pages;
            }
        }
        return $pageCount;
    }

    public function fetchOrderPrice(Request $request)
    {
        $answers = [];
        foreach ($request->data as $index => $value) {
            $answers[] = $value;
        }
        sort($answers);
        $answers = implode('-', $answers);
        $product = Product::find($request->product);

        if ($product->category->count_paper) {
            if ($product->typeRelatedFile and $request->type == 'double') {
                $count = $request->qty * ceil($request->pageCount / 2);
            } else
                $count = $request->qty * $request->pageCount;
        } else
            $count = $request->qty;

        $prices = ProductPrice::where('product_id', $request->product)->where('paper_id', $request->paper)->where('values', $answers)->where('min', '<=', $count)->where(function ($query) use ($count) {
            $query->where('max', '>=', $count)->whereOr('max', '');
        })->first();
        if (auth()->guard('customer')->user()) {
            if ($request->type == 'single') {
                return ta_persian_num(number_format($prices->coworker_single_price * $count) . " ریال");
            } else {
                return ta_persian_num(number_format($prices->coworker_double_price * $count) . " ریال");
            }
        } else {
            if ($request->type == 'single') {
                return ta_persian_num(number_format($prices->single_price * $count) . " ریال");
            } else {
                return ta_persian_num(number_format($prices->double_price * $count) . " ریال");
            }
        }

    }

    public function fetchPaperServices(Request $request)
    {
        $services = DB::table('product_services')->where('paper_id', $request->paper)->where('product_id', $request->product)->join('services', 'product_services.service_id', '=', 'services.id')->select(['services.id', 'services.name', 'allow_type'])->get();
        return json_encode($services);
    }

    public function fetchServiceProperties(Request $request)
    {
        $service = $request->service;
        $properties = ServiceProperty::where('service_id', $request->service)->get();
        $serviceProperties = [];
        foreach ($properties as $key => $property) {
            $serviceProperties[$key]['name'] = $property->name;
            $serviceProperties[$key]['id'] = $property->id;
            foreach ($property->ServiceValues as $key2 => $value) {
                $serviceProperties[$key]['values'][$key2]['name'] = $value->name;
                $serviceProperties[$key]['values'][$key2]['id'] = $value->id;
                $serviceProperties[$key]['values'][$key2]['picture'] = $value->picture;
            }
        }
        return json_encode($serviceProperties);
    }

    public function fetchServicePrice(Request $request)
    {
        $answers = [];
        foreach ($request->data as $index => $value) {
            $answers[] = $value;
        }
        sort($answers);
        $answers = implode('-', $answers);
        $product = Product::find($request->product);

        if ($product->category->count_paper) {
            if ($product->typeRelatedFile and $request->type == 'double') {
                $count = $request->qty * ceil($request->pageCount / 2);
            } else
                $count = $request->qty * $request->pageCount;
        } else
            $count = $request->qty;

        $prices = ProductPrice::where('product_id', $request->product)->where('values', $answers)->where('min', '<=', $count)->where(function ($query) use ($count) {
            $query->where('max', '>=', $count)->whereOr('max', '');
        })->first();
        if (auth()->guard('customer')->user()) {
            if ($request->type == 'single') {
                $values = [];
                foreach ($request->service as $key => $service) {
                    $values[] = $service;
                }
                sort($values);
                $servicePrices = ServicePrice::where('values', $values)->where('min', '<=', $count)->where(function ($query) use ($count) {
                    $query->where('max', '>=', $count)->whereOr('max', '');
                })->first();
                if ($servicePrices->service->allow_type)
                    return ta_persian_num(number_format(($prices->coworker_single_price + $servicePrices->coworker_single_price) * $count) . " ریال");
                else
                    return ta_persian_num(number_format(($prices->coworker_single_price + $servicePrices->coworker_price) * $count) . " ریال");
            } else {
                $values = [];
                foreach ($request->service as $key => $service) {
                    $values[] = $service;
                }
                sort($values);
                $servicePrices = ServicePrice::where('values', $values)->where('min', '<=', $count)->where(function ($query) use ($count) {
                    $query->where('max', '>=', $count)->whereOr('max', '');
                })->first();
                if ($servicePrices->service->allow_type)
                    return ta_persian_num(number_format(($prices->coworker_single_price + $servicePrices->coworker_double_price) * $count) . " ریال");
                else
                    return ta_persian_num(number_format(($prices->coworker_single_price + $servicePrices->coworker_price) * $count) . " ریال");

            }
        } else {
            if ($request->type == 'single') {
                $values = [];
                $sum = 0;
                foreach ($request->services as $service) {
                    foreach ($request->service as $key => $thisService) {
                        $values[] = $thisService;
                    }
                    sort($values);
                    $servicePrices = ServicePrice::where('service_id', $service)->where('paper_id', $request->paper)->where('values', $values)->where('min', '<=', $count)->where(function ($query) use ($count) {
                        $query->where('max', '>=', $count)->whereOr('max', '');
                    })->first();
                    if ($servicePrices->service->allow_type) {
                        if ($request->serviceFiles[$service] == 'single')
                            $sum += $servicePrices->single_price;
                        elseif ($request->serviceFiles[$service] == 'double')
                            $sum += $servicePrices->double_price;
                    } else
                        $sum += $servicePrices->price;
                }
                return ta_persian_num(number_format(($prices->single_price + $sum) * $count) . " ریال");

            } else {
                $values = [];
                $sum = 0;
                foreach ($request->services as $service) {
                    foreach ($request->service as $key => $thisService) {
                        $values[] = $thisService;
                    }
                    sort($values);
                    $servicePrices = ServicePrice::where('service_id', $service)->where('paper_id', $request->paper)->where('values', $values)->where('min', '<=', $count)->where(function ($query) use ($count) {
                        $query->where('max', '>=', $count)->whereOr('max', '');
                    })->first();
                    if ($servicePrices->service->allow_type)
                        $sum += $servicePrices->double_price;
                    else
                        $sum += $servicePrices->price;
                }
                return ta_persian_num(number_format(($prices->double_price + $sum) * $count) . " ریال");
            }
        }


    }

    public function storeCart(Request $request)
    {
        $data = [];
        foreach ($request->all() as $index => $item) {
            if (strpos($index, "property-") !== false) {
                $data[] = $item;
            } else {
                continue;
            }
        }
        $data = implode('-', $data);
        $product = Product::find($request->product);

        if ($product->category->count_paper) {
            $count = $request->qty;
            if ($request->type == 'double') {
                if ($product->typeRelatedFile) {
                    $splitedFile = explode('.', $request->session()->get('file.' . $request->product . '.front-file'));
                    if ($splitedFile[count($splitedFile) - 1] == 'pdf') {
                        $pdf = new PDFInfo(public_path('/orderFiles/' . ($request->session()->get('file.' . $request->product . '.front-file'))));
                        $pageCount = ceil($pdf->pages / 2);
                        $count = $count * $pageCount;
                    } else {
                        $count = $count * 1;
                    }
                } else {
                    $splitedFile = explode('.', $request->session()->get('file.' . $request->product . '.front-file'));
                    if ($splitedFile[count($splitedFile) - 1] == 'pdf') {
                        $pdf = new PDFInfo(public_path('/orderFiles/' . ($request->session()->get('file.' . $request->product . '.front-file'))));
                        $pageCount = $pdf->pages;
                    } else {
                        $pageCount = 1;
                    }
                    $splitedFile = explode('.', $request->session()->get('file.' . $request->product . '.back-file'));
                    if ($splitedFile[count($splitedFile) - 1] == 'pdf') {
                        $pdf = new PDFInfo(public_path('/orderFiles/' . ($request->session()->get('file.' . $request->product . '.back-file'))));
                        $pageCount += $pdf->pages;
                        $count = $count * $pageCount;
                    } else {
                        $pageCount += 1;
                        $count = $count * $pageCount;
                    }
                }
            } else {
                $splitedFile = explode('.', $request->session()->get('file.' . $request->product . '.front-file'));
                if ($splitedFile[count($splitedFile) - 1] == 'pdf') {
                    $pdf = new PDFInfo(public_path('/orderFiles/' . ($request->session()->get('file.' . $request->product . '.front-file'))));
                    $pageCount = $pdf->pages;
                    $count = $count * $pageCount;
                } else {
                    $count = $count * 1;
                }
            }
        } else
            $count = $request->qty;
        $prices = ProductPrice::where('product_id', $request->product)->where('values', $data)->where('min', '<=', $count)->where(function ($query) use ($count) {
            $query->where('max', '>=', $count)->whereOr('max', '');
        })->first();
        if (auth()->guard('customer')->user()) {
            if ($request->type == 'single') {
                $price = $prices->coworker_single_price * $count;
            } else {
                $price = $prices->coworker_double_price * $count;
            }
        } else {
            if ($request->type == 'single') {
                $price = $prices->single_price * $count;
            } else {
                $price = $prices->double_price * $count;
            }
        }

        $request->session()->push('cart', [
            'files' => [
                'front' => $request->session()->get('file.' . $request->product . '.front-file'),
                'back' => $request->session()->get('file.' . $request->product . '.back-file')
            ],
            'product' => $request->product,
            'qty' => $request->qty,
            'type' => $request->type,
            'data' => $data,
            'price' => $price
        ]);
        $request->session()->forget('file.' . $request->product . '.front-file');
        $request->session()->forget('file.' . $request->product . '.back-file');
        return redirect(route('cart'))->withErrors(['سفارش شما به سبد خرید اضافه شد'], 'success');
    }

    public function finalStep(Request $request)
    {
        dd($request->all());
    }

}
