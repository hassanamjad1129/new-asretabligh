<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slideshow;
use Illuminate\Http\Request;

class SlideshowController extends Controller
{
    public function __construct()
    {
    }

    public function create()
    {
        return view('admin.slideshows.create');
    }

    public function store(Request $request)
    {
        if (!$request->has('image')) {
            return redirect()->back()->withErrors(['لطفا تصویر را آپلود کنید'], 'feild');
        }
        Slideshow::create([
            'image' => $request->image
        ]);
        return redirect(route('admin.slideshow.index'))->withErrors(['تصویر با موفقیت به اسلایدشو افزوده شد'], 'success');
    }

    public function destroy($id = NULL)
    {
        $slideshow = Slideshow::find($id);
        if ($slideshow) {
            $slideshow->delete();
            return redirect()->back()->withErrors(['تصویر با موفقیت حذف شد'], 'success');
        }
        return redirect()->back()->withErrors(['داده نامعتبر'], 'feild');
    }

    public function index()
    {
        $slideshow = Slideshow::all();
        return view('admin.slideshows.index', ['slideshows' => $slideshow]);
    }

    public function setPriority(Request $request)
    {
        $slideshows = $request->input();
        foreach ($slideshows as $slideshow => $item):
            if ($slideshow != '_token' and $slideshow != 'dataTables-example_length') {
                $slideshow = str_replace('priority', '', $slideshow);
                $thisItem = Slideshow::find($slideshow);
                $thisItem->priority = $item;
                $thisItem->save();
            }
        endforeach;
        return redirect()->back()->withErrors(['اولویت تصاویر با موفقیت ویرایش شد'], 'success');

    }
}
