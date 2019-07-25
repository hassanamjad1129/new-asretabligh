<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Paper;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('papers');
        $papers = Paper::all();
        return view('admin.papers.index', ['papers' => $papers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('papers');
        return view('admin.papers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('papers');
        $validator = $this->storePaperValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator, 'failed');
        $paper = new Paper();
        $paper->name = $request->name;
        $paper->save();
        return redirect(route('admin.paper.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    private function storePaperValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'نام الزامیست'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Paper $paper
     * @return void
     * @throws AuthorizationException
     */
    public function edit(Paper $paper)
    {
        $this->authorize('papers');
        return view('admin.papers.edit', ['paper' => $paper]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Paper $paper
     * @return void
     * @throws AuthorizationException
     */
    public function update(Request $request, Paper $paper)
    {
        $this->authorize('papers');
        $validator = $this->storePaperValidation($request);
        if ($validator->fails())
            return back()->withErrors($validator, 'failed');
        $paper->name = $request->name;
        $paper->save();
        return redirect(route('admin.paper.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Paper $paper
     * @return void
     * @throws Exception
     */
    public function destroy(Paper $paper)
    {
        $this->authorize('papers');
        $paper->delete();
        return redirect(route('admin.paper.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function products(Paper $paper)
    {
        $this->authorize('paperProducts');
        $products = Product::all();
        return view('admin.papers.products', ['products' => $products, 'paper' => $paper]);
    }

    public function updateProducts(Request $request, Paper $paper)
    {
        $this->authorize('paperProducts');
        $paper->Products()->sync($request->products);
        return redirect(route('admin.paper.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
