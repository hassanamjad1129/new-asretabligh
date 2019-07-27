<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slideshow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class SlideshowController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('slideshows');
        return view('admin.slideshows.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('slideshows');
        if (!$request->has('image')) {
            return redirect()->back()->withErrors(['لطفا تصویر را آپلود کنید'], 'feild');
        }
        Slideshow::create([
            'image' => $request->image
        ]);
        return redirect(route('admin.slideshow.index'))->withErrors(['تصویر با موفقیت به اسلایدشو افزوده شد'], 'success');
    }

    /**
     * @param null $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy($id = NULL)
    {
        $this->authorize('slideshows');

        $slideshow = Slideshow::find($id);
        if ($slideshow) {
            $slideshow->delete();
            return redirect()->back()->withErrors(['تصویر با موفقیت حذف شد'], 'success');
        }
        return redirect()->back()->withErrors(['داده نامعتبر'], 'feild');
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('slideshows');
        $slideshow = Slideshow::all();
        return view('admin.slideshows.index', ['slideshows' => $slideshow]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function setPriority(Request $request)
    {
        $this->authorize('slideshows');
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
