<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('categories');
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('categories');
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validationStore(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'picture' => 'required|mimes:jpg,png,jpeg,gif,svg',
        ], [
            'name.required' => 'عنوان دسته بندی الزامی است',
            'picture.required' => 'تصویر دسته بندی الزامی است',
        ]);

    }

    public function categoriesPicturePath()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $user_id = auth()->guard('admin')->user()->id;
        return "/Categories/{$user_id}/{$year}/{$month}/{$day}";
    }


    private function smallPicture($image, $fileName,$width,$height)
    {

        define("WIDTH2", $width);
        define("HEIGHT2", $height);

        $dest_image = imagecreatetruecolor(WIDTH2, HEIGHT2);

        //make sure the transparency information is saved
        imagesavealpha($dest_image, true);

        //create a fully transparent background (127 means fully transparent)
        $trans_background = imagecolorallocatealpha($dest_image, 237, 237, 237, 0);

        //fill the image with a transparent background
        imagefill($dest_image, 0, 0, $trans_background);
        if (explode('.', $fileName)[count(explode('.', $fileName)) - 1] == 'png') {
            $sizes = (getimagesize($image));
            if ($sizes[0] >= $sizes[1]) {
                $img = imagecreatetruecolor($sizes[0], $sizes[0]);
                imagesavealpha($img, true);
                $color = imagecolorallocatealpha($img, 0, 0, 0, 127);
                imagefill($img, 0, 0, $color);
                $a = imagecreatefrompng($image);
                imagecopyresampled($img, $a, 0, ($sizes[0] - ($sizes[1] / $sizes[0]) * $sizes[0]) / 2, 0, 0, $sizes[0], ($sizes[1] / $sizes[0]) * $sizes[0], $sizes[0], $sizes[1]);
                imagepng($img, storage_path().'/app/Categories/' . 'cropped-' . $fileName);
            } else {
                $img = imagecreatetruecolor($sizes[1], $sizes[1]);
                imagesavealpha($img, true);
                $color = imagecolorallocatealpha($img, 0, 0, 0, 127);
                imagefill($img, 0, 0, $color);
                $a = imagecreatefromjpeg($image);
                imagecopyresampled($img, $a, ($sizes[1] - ($sizes[0] / $sizes[1]) * $sizes[1]) / 2, 0, 0, 0, ($sizes[0] / $sizes[1]) * $sizes[1], $sizes[1], $sizes[0], $sizes[1]);
                imagepng($img, storage_path().'/app/Categories/' . 'cropped-' . $fileName);
            }
            return 'Categories/' . 'cropped-' . $fileName;

        } else {
            //take create image resources out of the 3 pngs we want to merge into destination image
            $a = imagecreatefromjpeg($image);
            $a = imagerotate($a, 360, 0);
            list($width, $height) = getimagesize($image);
            if ($width / $height >= 1)
                imagecopyresampled($dest_image, $a, 0, (HEIGHT2 - ($height / $width) * WIDTH2) / 2, 0, 0, WIDTH2, ($height / $width) * WIDTH2, $width, $height);
            else
                imagecopyresampled($dest_image, $a, (WIDTH2 - ($width / $height) * HEIGHT2) / 2, 0, 0, 0, ($width / $height) * HEIGHT2, HEIGHT2, $width, $height);
            imagejpeg($dest_image, storage_path().'/app/Categories/' . 'cropped-' . $fileName, 100);
            return 'Categories/' . 'cropped-' . $fileName;
        }
    }


    public function store(Request $request)
    {
        $this->authorize('categories');
        $validator = $this->validationStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.categories.create'))->withErrors($validator, 'failed')->withInput();
        }
        $category = new Category();
        $category->status = ($request->status == "on") ? 1 : 0;
        $category->name = $request->name;
        $category->count_paper = $request->count_pages == "yes" ? true : false;
        $category->picture = $this->uploadFile($request->picture, $this->categoriesPicturePath());
        $category->thumbnail_picture = $this->smallPicture(storage_path().'/app/'. $category->picture , explode('/', $category->picture )[count(explode('/', $category->picture )) - 1],259,209);
        $category->description = $request->description;
        $category->save();
        return redirect(route('admin.categories.index'))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    public function categoryPicture(Category $category)
    {
        return Storage::download($category->picture);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Category $category
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Category $category)
    {
        $this->authorize('categories');
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function validationUpdate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'عنوان دسته بندی الزامی است'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('categories');
        $validator = $this->validationUpdate($request);
        if ($validator->fails()) {
            return redirect(route('admin.categories.create'))->withErrors($validator, 'failed')->withInput();
        }
        $category->status = ($request->status == "on") ? 1 : 0;
        $category->name = $request->name;
        $category->count_paper = $request->count_paper;
        if ($request->picture) {
            $category->picture = $this->uploadFile($request->picture, $this->categoriesPicturePath());
            $category->thumbnail_picture = $this->smallPicture(storage_path().'/app/'. $category->picture , explode('/', $category->picture )[count(explode('/', $category->picture )) - 1],259,209);

        }
        if ($request->description)
            $category->description = $request->description;
        $category->update();
        return redirect(route('admin.categories.index'))->withErrors('عملیات با موفقیت انجام شد', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $this->authorize('categories');
        $category->delete();
        return redirect(route('admin.categories.index'))->withErrors('عملیات با موفقیت انجام شد', 'failed');
    }
}
