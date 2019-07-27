<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\discount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class DiscountController extends Controller
{

    public function index()
    {
        $discounts = discount::all();
        return view('admin.discount.index', ['discounts' => $discounts]);
    }

    public function changeStatus(discount $discount)
    {
        if ($discount->status == 1) {
            $discount->status = '0';
        } elseif ($discount->status == 0) {
            $discount->status = '1';
        }
        $discount->save();
        return redirect()->route('admin.discount.index')->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    public function delete(discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discount.index')->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    public function createType()
    {
        return view('admin.discount.type');
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.discount.create', compact('customers', 'products'));
    }

    public function generateCode()
    {
        return strtoupper(str_random(6));
    }

    private function validationDicount(Request $request,$discount=null)
    {
        return Validator::make($request->all(), [
            'count_discount' => ['nullable', 'integer'],
            'type_doing' => ['required', Rule::in(['cash', 'percentage'])],
            'discount_value' => ['required', 'numeric'],
            'minimum_price' => ['nullable', 'numeric'],
            'maximum_price' => ['nullable', 'numeric'],
            'code' => ['required', $discount==null?'unique:discounts':Rule::unique('discounts','id')->ignore($discount->id)]
        ], [
            'count_discount.integer' => 'نوع تعداد دفعات تخفیف باید از نوع عددی باشد',
            'discount_value.required' => 'مقدار تخفیف اجباری است',
            'maximum_price.numeric' => 'حداکثر قیمت باید از نوع عددی باشد',
            'minimum_price.numeric' => 'حداقل قیمت باید از نوع عددی باشد',
            'code.required' => 'کد تخفیف اجباری است',
            'code.unique' => 'کد تخفیف شما تکراری است'
        ]);
    }

    public function store(Request $request)
    {
        $validation = $this->validationDicount($request);
        if ($validation->fails())
            return back()->withErrors($validation, 'failed')->withInput();

        $started_at = $finished_at = '';
        if ($request->started_at != '')
            $started_at = $this->changeDateTime($request->started_at);
        if ($request->finished_at != '')
            $finished_at = $this->changeDateTime($request->finished_at);

        if ($started_at AND $finished_at)
            if ($started_at >= $finished_at)
                return back()->withErrors('تاریخ شروع از تاریخ پایان بزرگ تر یا مساوی است', 'failed')->withInput();

        $minimum_price = $maximum_price = '';
        if ($request->minimum_price != '')
            $minimum_price = $request->minimum_price;
        if ($request->maximum_price != '')
            $maximum_price = $request->maximum_price;

        if ($minimum_price AND $maximum_price)
            if ($minimum_price >= $maximum_price)
                return back()->withErrors('حداقل قیمت از حداکثر قیمت کوچکتر یا مساوی است', 'failed')->withInput();

        if($request->type_doing == 'cash')
            if($request->discount_value > $minimum_price)
                return back()->withErrors('حداقل قیمت کوچکتر از مقدار تخفیف است', 'failed')->withInput();

        DB::beginTransaction();
        try{

            $discount = new discount();
            $discount->title = $request->title;
            $discount->status = 1;
            $discount->count_discount = $request->count_discount ? $request->count_discount : 0;
            $discount->code = strtoupper($request->code);
            $discount->type_doing = $request->type_doing;
            $discount->value = $request->discount_value;
            $discount->started_at = $started_at?$started_at:null;
            $discount->finished_at = $finished_at?$finished_at:null;
            $discount->maximum_price = $maximum_price?$maximum_price:null;
            $discount->minimum_price = $minimum_price?$minimum_price:null;
            $discount->all_users = $request->all_users=="true" ? 1 : 0;
            $discount->all_products = $request->all_products == "true" ? 1 : 0;
            $discount->first_order = $request->first_order==1?1:0;
            $discount->save();
            if($discount->all_users == 0)
                $discount->customers()->sync($request->customers);
            if($discount->all_products == 0)
                $discount->products()->sync($request->products);
            DB::commit();
            return redirect()->route('admin.discount.index')->withErrors('عملیات با موفقیت انجام شد','success');
        }catch (QueryException $e){
            DB::rollBack();
            return back()->withErrors('مشکلی پیش آمده','failed');
        }
    }

    private function changeDateTime($date)
    {

        try {
            $srting = $date;
            $srting = str_replace('۰', '0', $srting);
            $srting = str_replace('۱', '1', $srting);
            $srting = str_replace('۲', '2', $srting);
            $srting = str_replace('۳', '3', $srting);
            $srting = str_replace('۴', '4', $srting);
            $srting = str_replace('۵', '5', $srting);
            $srting = str_replace('۶', '6', $srting);
            $srting = str_replace('۷', '7', $srting);
            $srting = str_replace('۸', '8', $srting);
            $srting = str_replace('۹', '9', $srting);

            $started_at = explode(' ', $srting);
            $started_at_date = explode('/', $started_at[0]);
            $started_at_time = explode(':', $started_at[1]);

            return (new Jalalian((int)$started_at_date[0], (int)$started_at_date[1], (int)$started_at_date[2], (int)$started_at_time[0], (int)$started_at_time[1], (int)$started_at_time[2]))->toCarbon()->toDateTimeString();
        } catch (\Exception $e) {
            return back()->withErrors('فرمت تاریخ وارد شده نادرست است', 'failed');
        }
    }


    public function edit(discount $discount){
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.discount.edit',compact('discount','customers','products'));
    }

    public function update(Request $request,discount $discount){
        $validation = $this->validationDicount($request,$discount);
        if ($validation->fails())
            return redirect()->route('admin.discount.edit',$discount)->withErrors($validation, 'failed');

        $started_at = $finished_at = '';
        if ($request->started_at != '')
            $started_at = $this->changeDateTime($request->started_at);
        if ($request->finished_at != '')
            $finished_at = $this->changeDateTime($request->finished_at);

        if ($started_at AND $finished_at)
            if ($started_at >= $finished_at)
                return redirect()->route('admin.discount.edit',$discount)->withErrors('تاریخ شروع از تاریخ پایان بزرگ تر یا مساوی است', 'failed');

        $minimum_price = $maximum_price = '';
        if ($request->minimum_price != '')
            $minimum_price = $request->minimum_price;
        if ($request->maximum_price != '')
            $maximum_price = $request->maximum_price;

        if ($minimum_price AND $maximum_price)
            if ($minimum_price >= $maximum_price)
                return redirect()->route('admin.discount.edit',$discount)->withErrors('حداقل قیمت از حداکثر قیمت کوچکتر یا مساوی است', 'failed');

        if($request->type_doing == 'cash')
            if($request->discount_value > $minimum_price)
                return back()->withErrors('حداقل قیمت کوچکتر از مقدار تخفیف است', 'failed')->withInput();

        DB::beginTransaction();
        try{

            $discount->title = $request->title;
            $discount->status = 1;
            $discount->count_discount = $request->count_discount ? $request->count_discount : 0;
            $discount->code = strtoupper($request->code);
            $discount->type_doing = $request->type_doing;
            $discount->value = $request->discount_value;
            $discount->started_at = $started_at?$started_at:null;
            $discount->finished_at = $finished_at?$finished_at:null;
            $discount->maximum_price = $maximum_price?$maximum_price:null;
            $discount->minimum_price = $minimum_price?$minimum_price:null;
            $discount->all_users = $request->all_users=="true" ? 1 : 0;
            $discount->all_products = $request->all_products=="true" ? 1 : 0;
            $discount->first_order = $request->first_order==1?1:0;
            $discount->save();
            if($discount->all_users == 0)
                $discount->customers()->sync($request->customers);
            elseif ($discount->all_users == 1)
                $discount->customers()->sync([]);

            if($discount->all_products == 0)
                $discount->products()->sync($request->products);
            elseif($discount->all_products == 1)
                $discount->products()->sync([]);

            DB::commit();
            return redirect()->route('admin.discount.index')->withErrors('عملیات با موفقیت انجام شد','success');
        }catch (QueryException $e){
            DB::rollBack();
            return redirect()->route('admin.discount.edit',$discount)->withErrors('مشکلی پیش آمده','failed');
        }
    }

}
