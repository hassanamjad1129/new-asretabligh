<?php

namespace App\Http\Controllers;

use App\BestCustomer;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductValue;
use App\Models\Slideshow;
use App\option;
use App\pCategory;
use App\post;
use App\Service;
use App\ServiceValue;
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

    public function getServicePicture(ServiceValue $service)
    {
        return Storage::download($service->picture);
    }

    public function cart()
    {
        $carts = Session::get('cart');
        return view('customer.showAllCarts', ['carts' => $carts]);
    }

    public function removeFromCart($id)
    {
        Session::forget('cart.' . $id);
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    public function getCategoryProductPrice($category)
    {
        $category = Category::where('name', str_replace("-", " ", $category))->firstOrFail();
        $products = $category->products;
        return view('categoryProductPrice', ['products' => $products, 'category' => $category]);
    }

    public function rules()
    {
        return view('client.rules');
    }

    public function aboutus()
    {
        return view('client.aboutUs');
    }

    public function posts()
    {
        $posts = post::latest()->paginate(7);
        $categories = pCategory::all();
        $newPosts = post::latest()->get()->take(4);
        return view('client.archive', ['posts' => $posts, 'categories' => $categories, 'newPosts' => $newPosts]);

    }

    public function postDetail(post $post, $title)
    {
        $post->increment('seen', 1);
        $post->save();
        $categories = pCategory::all();
        $newPosts = post::latest()->get()->take(4);
        return view('client.post', ['post' => $post, 'categories' => $categories, 'newPosts' => $newPosts]);
    }
}
