<?php

namespace App\Http\Controllers\Admin;

use App\shipping;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ShippingController extends Controller
{
    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('shippings');
        return view('admin.shippings.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('shippings');
        $shipping = new shipping();
        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->take_address = $request->take_address ? $request->take_address : 0;
        $shipping->icon = $request->filepath;
        $shipping->price = $request->price;
        $shipping->save();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * @param shipping $shipping
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(shipping $shipping)
    {
        $this->authorize('shippings');
        return view('admin.shippings.edit', ['shipping' => $shipping]);
    }

    /**
     * @param shipping $shipping
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(shipping $shipping, Request $request)
    {
        $this->authorize('shippings');
        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->take_address = $request->take_address ? $request->take_address : 0;
        $shipping->icon = $request->filepath;
        $shipping->price = $request->price;
        $shipping->save();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد.'], 'success');
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('shippings');
        $shippings = shipping::all();
        return view('admin.shippings.index', ['shippings' => $shippings]);
    }

    /**
     * @param shipping $shipping
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy(shipping $shipping)
    {
        $this->authorize('shippings');
        $shipping->delete();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * @param shipping $shipping
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function restore(shipping $shipping)
    {
        $this->authorize('shippings');
        $shipping->status = 0;
        $shipping->save();
        return redirect(route('admin.shipping.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

}
