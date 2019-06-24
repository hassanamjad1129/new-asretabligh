<?php

namespace App\Http\Controllers;

use App\BestCustomer;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductValue;
use App\Models\Slideshow;
use App\option;
use App\post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class siteController extends Controller
{
    public function index()
    {
        $slideshow = slideshow::orderBy('priority', 'desc')->get();
        $bestCustomers = BestCustomer::all();
        $property = option::where('option_name', 'property')->first()->option_value;
        $news = post::latest()->take(3)->get();
        $categories = Category::with('products')->get();

        $discounts = Collection::make();
        return view('client.index', [
            'slideshows' => $slideshow,
            'bestCustomers' => $bestCustomers,
            'news' => $news,
            'discounts' => $discounts,
            'property' => $property,
            'categories' => $categories
        ]);
    }

    public function getProductPicture(Product $product)
    {
        return Storage::download($product->picture);
    }

    public function getCategoryPicture(Category $category)
    {
        return Storage::download($category->picture);
    }

    public function getValuePicture(ProductValue $value)
    {
        return Storage::download($value->picture);
    }

    public function cart()
    {
        $carts = Session::get('cart');
        return view('customer.showAllCarts', ['carts' => $carts]);
    }

    public function removeFromCart($id)
    {
        Session::forget('cart.' . $id);
        return back()->withErrors(['عملیات با موفقیت انجام شد'],'success');
    }
}
