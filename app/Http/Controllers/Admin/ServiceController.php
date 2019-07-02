<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', ['services' => $services]);
    }

    public function create()
    {
        return view('admin.services.create');
    }

    private function storeRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required'],
            'allow_type' => ['required', Rule::in(['0', '1'])]
        ]);
    }

    public function store(Request $request)
    {
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

    public function edit(Service $service)
    {
        return view('admin.services.edit', ['service' => $service]);
    }

    public function update(Service $service, Request $request)
    {
        $validator = $this->storeRequest($request);
        if ($validator->fails())
            return back()->withErrors($validator, 'failed');
        $service->name = $request->name;
        $service->description = $request->description;
        $service->allow_type = $request->allow_type;
        $service->save();
        return redirect(route('admin.service.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect(route('admin.service.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function products(Service $service)
    {
        $products = Product::all();
        return view('admin.services.products', [
            'products' => $products,
            'service' => $service
        ]);
    }

    public function updateProducts(Service $service, Request $request)
    {
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
