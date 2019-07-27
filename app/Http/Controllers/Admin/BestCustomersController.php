<?php

namespace App\Http\Controllers\Admin;

use App\BestCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class BestCustomersController extends Controller
{
    public function __construct()
    {
    }


    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('bestCustomers');
        $bestCustomers = BestCustomer::all();
        return view('admin.bestCustomers.index', ['bestCustomers' => $bestCustomers]);
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('bestCustomers');
        return view('admin.bestCustomers.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('bestCustomers');
        if (!$request->has('picture'))
            return back()->withErrors(['خطا! تصویر را آپلود کنید']);
        $bestCustomer = new BestCustomer();
        $bestCustomer->image = $request->picture;
        $bestCustomer->title = $request->title;
        $bestCustomer->save();
        return redirect('/admin/bestCustomers')->withErrors(['مشتری با موفقیت ثبت شد'], 'success');
    }

    /**
     * @param null $id
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy($id = NULL)
    {
        $this->authorize('bestCustomers');
        $banner = BestCustomer::findOrFail($id);
        $banner->delete();
        return redirect('/admin/bestCustomers')->withErrors(['مشتری با موفقیت حذف شد'], 'success');
    }
}
