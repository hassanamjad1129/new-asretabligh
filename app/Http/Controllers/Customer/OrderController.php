<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Order;
use App\OrderItem;
use App\OrderItemService;
use App\OrderItemServiceFile;
use App\Service;
use App\ServicePrice;
use App\ServiceProperty;
use App\Services\Gateway;
use App\Services\IranKishPayment\Irankish;
use App\shipping;
use Exception;
use Howtomakeaturn\PDFInfo\PDFInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ATCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Larautility\Gateway\Exceptions\RetryException;
use Larautility\Gateway\Mellat\Mellat;
use Larautility\Gateway\Zarinpal\Zarinpal;

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
            if ($product->typeRelatedFile == false and $request->type == 'double') {
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
            if ($product->typeRelatedFile == false and $request->type == 'double') {
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
                $sum = 0;
                foreach ($request->services as $service) {
                    $service = Service::find($service);
                    $values = [];

                    foreach ($service->ServiceProperties as $property) {
                        if ($request->has('service.service-' . $property->id))
                            $values[] = $request->service['service-' . $property->id];
                    }
                    sort($values);
                    $servicePrices = ServicePrice::where('values', implode("-", $values))->where('min', '<=', $count)->where(function ($query) use ($count) {
                        $query->where('max', '>=', $count)->whereOr('max', '');
                    })->first();
                    if ($servicePrices->service->allow_type) {
                        if ($request->serviceFiles[$service->id] == 'single') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->coworker_single_price * $count);
                            else
                                $sum += ($servicePrices->coworker_single_price * $request->qty);
                        } elseif ($request->serviceFiles[$service->id] == 'double') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->coworker_double_price * $count);
                            else
                                $sum += ($servicePrices->coworker_double_price * $request->qty);
                        }
                    } else {
                        if ($service->paper_count)
                            $sum += ($servicePrices->coworker_price * $count);
                        else
                            $sum += ($servicePrices->coworker_price * $request->qty);
                    }
                }
                return ta_persian_num(number_format((($prices->coworker_single_price * $count) + $sum)) . " ریال");
            } else {
                $sum = 0;
                foreach ($request->services as $service) {
                    $service = Service::find($service);
                    $values = [];

                    foreach ($service->ServiceProperties as $property) {
                        if ($request->has('service.service-' . $property->id))
                            $values[] = $request->service['service-' . $property->id];
                    }
                    sort($values);
                    $servicePrices = ServicePrice::where('values', implode("-", $values))->where('min', '<=', $count)->where(function ($query) use ($count) {
                        $query->where('max', '>=', $count)->whereOr('max', '');
                    })->first();
                    if ($servicePrices->service->allow_type) {
                        if ($request->serviceFiles[$service->id] == 'single') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->coworker_single_price * $count);
                            else
                                $sum += ($servicePrices->coworker_single_price * $request->qty);
                        } elseif ($request->serviceFiles[$service->id] == 'double') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->coworker_double_price * $count);
                            else
                                $sum += ($servicePrices->coworker_double_price * $request->qty);
                        }
                    } else {
                        if ($service->paper_count)
                            $sum += ($servicePrices->coworker_price * $count);
                        else
                            $sum += ($servicePrices->coworker_price * $request->qty);
                    }
                }
                return ta_persian_num(number_format((($prices->coworker_double_price * $count) + $sum)) . " ریال");
            }
        } else {
            if ($request->type == 'single') {
                $values = [];
                $sum = 0;
                foreach ($request->services as $service) {
                    $values = [];
                    $service = Service::find($service);
                    foreach ($service->ServiceProperties as $property) {
                        if ($request->has('service.service-' . $property->id))
                            $values[] = $request->service['service-' . $property->id];
                    }
                    sort($values);
                    $servicePrices = ServicePrice::where('service_id', $service->id)->where('paper_id', $request->paper)->where('values', implode("-", $values))->where('min', '<=', $count)->where(function ($query) use ($count) {
                        $query->where('max', '>=', $count)->whereOr('max', '');
                    })->first();
                    if ($servicePrices->service->allow_type) {
                        if ($request->serviceFiles[$service->id] == 'single') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->coworker_single_price * $count);
                            else
                                $sum += ($servicePrices->coworker_single_price * $request->qty);
                        } elseif ($request->serviceFiles[$service->id] == 'double') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->coworker_double_price * $count);
                            else
                                $sum += ($servicePrices->coworker_double_price * $request->qty);
                        }
                    } else {
                        if ($service->paper_count)
                            $sum += ($servicePrices->coworker_price * $count);
                        else
                            $sum += ($servicePrices->coworker_price * $request->qty);
                    }
                }
                return ta_persian_num(number_format((($prices->single_price * $count) + $sum)) . " ریال");

            } else {
                $values = [];
                $sum = 0;
                foreach ($request->services as $service) {
                    $service = Service::find($service);
                    $values = [];

                    foreach ($service->ServiceProperties as $property) {
                        if ($request->has('service.service-' . $property->id))
                            $values[] = $request->service['service-' . $property->id];
                    }
                    sort($values);
                    $servicePrices = ServicePrice::where('values', implode("-", $values))->where('min', '<=', $count)->where(function ($query) use ($count) {
                        $query->where('max', '>=', $count)->whereOr('max', '');
                    })->first();

                    if ($servicePrices->service->allow_type) {
                        if ($request->serviceFiles[$service->id] == 'single') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->single_price * $count);
                            else
                                $sum += ($servicePrices->single_price * $request->qty);
                        } elseif ($request->serviceFiles[$service->id] == 'double') {
                            if ($service->paper_count)
                                $sum += ($servicePrices->double_price * $count);
                            else
                                $sum += ($servicePrices->double_price * $request->qty);
                        }
                    } else {
                        if ($service->paper_count)
                            $sum += ($servicePrices->price * $count);
                        else
                            $sum += ($servicePrices->price * $request->qty);

                    }
                }
                return ta_persian_num(number_format(($prices->double_price * $count) + $sum) . " ریال");

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
                if ($product->typeRelatedFile == false) {
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
        $prices = ProductPrice::where('product_id', $request->product)->where('paper_id', $request->paper)->where('values', $data)->where('min', '<=', $count)->where(function ($query) use ($count) {
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
        $services = [];
        if ($request->service)
            foreach ($request->service as $key => $service) {
                $values = [];
                $servicePrice = 0;
                $service = Service::find($service);
                foreach ($service->ServiceProperties as $property) {
                    if ($request->has('service-' . $property->id))
                        $values[] = $request->input('service-' . $property->id);
                }
                sort($values);
                $servicePrices = ServicePrice::where('paper_id', $request->paper)->where('values', implode("-", $values))->where('min', '<=', $count)->where(function ($query) use ($count) {
                    $query->where('max', '>=', $count)->whereOr('max', '');
                })->first();
                $services[$key]['id'] = $service->id;
                $services[$key]['properties'] = $values;
                if ($servicePrices->service->allow_type) {
                    if ($request->input('service-type-' . $service->id) == 'single') {
                        if (auth()->guard('customer')->user()) {
                            if ($service->paper_count)
                                $servicePrice = ($servicePrices->coworker_single_price * $count);
                            else
                                $servicePrice = ($servicePrices->coworker_single_price * $request->qty);
                        } else {
                            if ($service->paper_count)
                                $servicePrice = ($servicePrices->single_price * $count);
                            else
                                $servicePrice = ($servicePrices->single_price * $request->qty);
                        }
                    } elseif ($request->input('service-type-' . $service->id) == 'double') {
                        if (auth()->guard('customer')->user()) {
                            if ($service->paper_count)
                                $servicePrice = ($servicePrices->coworker_double_price * $count);
                            else
                                $servicePrice = ($servicePrices->coworker_double_price * $request->qty);
                        } else {
                            if ($service->paper_count)
                                $servicePrice = ($servicePrices->double_price * $count);
                            else
                                $servicePrice = ($servicePrices->double_price * $request->qty);
                        }
                    }
                } else
                    $servicePrice = $servicePrices->price;
                $services[$key]['price'] = $servicePrice;
                $services[$key]['type'] = $request->input('service-type-' . $service->id);
                if ($servicePrices->service->allow_type) {
                    if ($request->input('service-type-' . $service->id) == 'single') {
                        $destinationPath = 'ServiceFiles'; // upload path
                        $extension = $request->file('service-front-file-' . $service->id)->getClientOriginalExtension(); // getting image extension
                        $fileName = rand(1111111111, 99999999999) . '.' . $extension; // rename image
                        $request->file('service-front-file-' . $service->id)->move($destinationPath, $fileName); // uploading file to given path
                        $services[$key]['files'] = [
                            'front' => $destinationPath . "/" . $fileName
                        ];
                    } else {
                        $destinationPath = 'ServiceFiles'; // upload path
                        $frontExtension = $request->file('service-front-file-' . $service->id)->getClientOriginalExtension(); // getting image extension
                        $backExtension = $request->file('service-back-file-' . $service->id)->getClientOriginalExtension(); // getting image extension
                        $frontFileName = rand(1111111111, 99999999999) . '.' . $frontExtension; // rename image
                        $backFileName = rand(1111111111, 99999999999) . '.' . $backExtension; // rename image
                        $request->file('service-front-file-' . $service->id)->move($destinationPath, $frontFileName); // uploading file to given path
                        $request->file('service-back-file-' . $service->id)->move($destinationPath, $backFileName); // uploading file to given path

                        $services[$key]['files'] = [
                            'front' => $destinationPath . "/" . $frontFileName,
                            'back' => $destinationPath . "/" . $backFileName
                        ];
                    }
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
            'price' => $price,
            'services' => $services,
            'paper' => $request->paper
        ]);
        $request->session()->forget('file.' . $request->product . '.front-file');
        $request->session()->forget('file.' . $request->product . '.back-file');
        return redirect(route('cart'))->withErrors(['سفارش شما به سبد خرید اضافه شد'], 'success');
    }

    public function finalStep(Request $request)
    {
        $shippings = shipping::all();
        $carts = [];
        if (!$request->carts)
            return back()->withErrors(['هیچ محصولی انتخاب نشده است'], 'failed');
        foreach ($request->carts as $cart) {
            $carts[] = $request->session()->get('cart.' . $cart);
        }
        return view('customer.finalStep', ['shippings' => $shippings, 'carts' => $carts, 'indexes' => $request->carts]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function storeOrder(Request $request)
    {
        $validator = $this->storeOrderValidation($request);
        if ($validator->fails())
            return redirect(route('cart'))->withErrors($validator->errors()->all(), 'failed');
        /*if ($this->checkCart($request))
            return redirect(route('cart'))->withErrors(['خطا! داده نامعتبر'], 'failed')->withInput();*/
        $sum = $this->getSumOfOrderPrices($request);

        if ($request->payment_method == 'money_bag' and !$this->checkCredit($sum))
            return redirect(route('cart'))->withErrors(['خطا! داده نامعتبر'], 'failed')->withInput();

        $shipping = shipping::find($request->shipping);
        if ($shipping->take_address and !$request->address)
            return redirect(route('cart'))->withErrors(['خطا! آدرس را وارد کنید'], 'failed')->withInput();

        $order = $this->storeOrderObject($request, $sum);
        $this->storeItems($request, $order);

        if ($request->payment_method == 'money_bag') {
            $this->reduceMoneyBag($sum);
            $order->payed = 1;
            $order->save();
            foreach ($request->cart as $cart)
                $request->session()->forget('cart.' . $cart);
            return redirect('/')->withErrors(['عملیات با موفقیت انجام شد'], 'success');
        } else {
            try {
                $gateway = Gateway::make(new Mellat());


                $gateway->price($sum)->ready();
                $transID = $gateway->transactionId();
                $order->transaction_id = $transID;
                $order->save();

                return $gateway->redirect();
            } catch (Exception $e) {

                return $e->getMessage();
            }
        }
    }

    private function storeOrderObject(Request $request, $sum, $transaction_id = null)
    {
        $order = new Order();
        $order->transaction_id = $transaction_id;
        $order->total_price = $sum;
        $order->user_id = auth()->guard('customer')->user()->id;
        $order->payed = 0;
        $order->address = $request->address;
        $order->delivery_method = $request->shipping;
        $order->discount = null;
        $order->payment_method = $request->payment_method;
        $order->save();
        return $order;
    }

    private function storeOrderItems($cart, Order $order)
    {
        $product = Product::find($cart['product']);
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $product->id;
        $orderItem->category_id = $product->category_id;
        $orderItem->data = $cart['data'];
        $orderItem->price = $cart['price'];
        $orderItem->type = $cart['type'];
        $orderItem->paper_id = $cart['paper'];
        $orderItem->qty = $cart['qty'];
        $orderItem->user_id = auth()->guard('customer')->user()->id;
        $orderItem->save();
        if ($cart['services'])
            $this->storeOrderItemServices($cart, $orderItem);
    }

    private function storeOrderItemServices($cart, OrderItem $orderItem)
    {
        if ($cart['services'])
            foreach ($cart['services'] as $service) {
                $orderItemService = new OrderItemService();
                $orderItemService->order_item_id = $orderItem->id;
                $orderItemService->service_id = $service['id'];
                $orderItemService->data = implode('-', $service['properties']);
                $orderItemService->price = $service['price'];
                if (isset($service['type']))
                    $orderItemService->type = $service['type'];
                $orderItemService->save();
                if (isset($service['type']))
                    $this->storeOrderItemServiceFiles($orderItemService, $service['files']);
            }
    }

    private function storeOrderItemServiceFiles(OrderItemService $orderItemService, $files)
    {
        $orderItemServiceFile = new OrderItemServiceFile();
        $orderItemServiceFile->order_item_service_id = $orderItemService->id;
        $orderItemServiceFile->front_file = $files['front'];
        if (isset($files['back']))
            $orderItemServiceFile->back_file = $files['back'];
        $orderItemServiceFile->save();
    }

    private function checkCredit($totalPrice)
    {
        if (auth()->guard('customer')->user()->credit < $totalPrice)
            return false;
        return true;
    }

    private function checkCart(Request $request)
    {
        foreach ($request->cart as $cart) {
            if (!$request->session()->has('cart.' . $cart . '.product')) {
                return false;
            }
        }
        return true;
    }

    private function storeOrderValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'cart' => ['required', 'array', 'present'],
            'shipping' => ['required', Rule::exists('shippings', 'id')],
            'payment_method' => ['required', Rule::in(['online', 'money_bag'])]
        ], [
            'cart.required' => 'آیتمی برای سفارش انتخاب نشده است',
            'shipping.required' => 'روشی جهت ارسال سفارش انتخاب نشده است',
            'shipping.exists' => 'روش ارسال انتخاب شده نامعتبر است'
        ]);
    }

    private function getSumOfOrderPrices(Request $request)
    {
        $sum = 0;
        foreach ($request->cart as $cart) {
            $cart = $request->session()->get('cart.' . $cart);
            $sum += $cart['price'];
            $servicePrice = 0;
            foreach ($cart['services'] as $service) {
                $servicePrice += $service['price'];
            }
            $sum += $servicePrice;
        }
        return $sum;
    }

    private function storeItems(Request $request, Order $order)
    {
        foreach ($request->cart as $cart) {
            $cart = $request->session()->get('cart.' . $cart);
            $this->storeOrderItems($cart, $order);
        }
    }

    private function reduceMoneyBag($sum)
    {
        $customer = auth()->guard('customer')->user();
        $customer->credit = $customer->credit - $sum;
        $customer->save();
    }


    public function verifyOrder(Request $request)
    {
        try {

            $gateway = Gateway::verify();

            $order = Order::where('transaction_id', $request->transaction_id)->firstOrFail();
            $order->payed = 1;
            $order->save();
            foreach ($order->orderItems as $orderItem) {
                $orderItem->status = 1;
                $orderItem->save();
                $request->session()->forget('cart');
            }
            return redirect('/')->withErrors(['عملیات با موفقیت انجام شد'], 'success');

        } catch (RetryException $e) {

            // تراکنش قبلا سمت بانک تاییده شده است و
            // کاربر احتمالا صفحه را مجددا رفرش کرده است
            // لذا تنها فاکتور خرید قبل را مجدد به کاربر نمایش میدهیم

            echo $e->getMessage() . "<br>";

        } catch (Exception $e) {

            // نمایش خطای بانک
            echo $e->getMessage();
        }

    }

    public function index()
    {
        $orders = orderItem::where('status', '>=', 1)->where('user_id', auth()->guard('customer')->user()->id)->latest()->get();
        return view('customer.orders.index', ['orders' => $orders]);
    }

    public function orderDetail(OrderItem $orderItem)
    {
        return view('customer.orders.detail', ['orderItem' => $orderItem]);
    }

}
