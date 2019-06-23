<?php

namespace App\Http\Controllers\Admin;

use App\BestCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BestCustomersController extends Controller
{
    public function __construct()
    {
    }


    public function index()
    {
        $bestCustomers = BestCustomer::all();
        return view('admin.bestCustomers.index', ['bestCustomers' => $bestCustomers]);
    }

    public function create()
    {
        return view('admin.bestCustomers.create');
    }

    public function store(Request $request)
    {
        if (!$request->has('picture'))
            return back()->withErrors(['خطا! تصویر را آپلود کنید']);
        $bestCustomer = new BestCustomer();
        $bestCustomer->image = $request->picture;
        $bestCustomer->title = $request->title;
        $bestCustomer->save();
        return redirect('/admin/bestCustomers')->withErrors(['مشتری با موفقیت ثبت شد'], 'success');
    }

    public function destroy($id = NULL)
    {
        $banner = BestCustomer::findOrFail($id);
        $banner->delete();
        return redirect('/admin/bestCustomers')->withErrors(['مشتری با موفقیت حذف شد'], 'success');
    }
}
