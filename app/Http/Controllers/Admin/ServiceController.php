<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('services');
        $services = Service::all();
        return view('admin.services.index', ['services' => $services]);
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('services');
        return view('admin.services.create');
    }

    private function storeRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required'],
            'allow_type' => ['required', Rule::in(['0', '1'])]
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('services');
        $validator = $this->storeRequest($request);
        if ($validator->fails())
            return back()->withErrors($validator, 'failed');
        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->allow_type = $request->allow_type;
        $service->save();
        return redirect(route('admin.service.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * @param Service $service
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Service $service)
    {
        $this->authorize('services');
        return view('admin.services.edit', ['service' => $service]);
    }

    /**
     * @param Service $service
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Service $service, Request $request)
    {
        $this->authorize('services');
        $validator = $this->storeRequest($request);
        if ($validator->fails())
            return back()->withErrors($validator, 'failed');
        $service->name = $request->name;
        $service->description = $request->description;
        $service->allow_type = $request->allow_type;
        $service->save();
        return redirect(route('admin.service.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * @param Service $service
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy(Service $service)
    {
        $this->authorize('services');
        $service->delete();
        return redirect(route('admin.service.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * @param Service $service
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function products(Service $service)
    {
        $this->authorize('serviceProducts');
        $products = Product::all();
        return view('admin.services.products', [
            'products' => $products,
            'service' => $service
        ]);
    }

    /**
     * @param Service $service
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updateProducts(Service $service, Request $request)
    {
        $this->authorize('serviceProducts');
        DB::table('product_services')->where('service_id', $service->id)->delete();
        foreach ($request->products as $product) {
            $productPaper = explode('-', $product);
            if (!$service->haveProductPaper($productPaper[0], $productPaper[1]))
                DB::table('product_services')->insert([
                    'service_id' => $service->id,
                    'product_id' => $productPaper[0],
                    'paper_id' => $productPaper[1],
                ]);
        }
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
