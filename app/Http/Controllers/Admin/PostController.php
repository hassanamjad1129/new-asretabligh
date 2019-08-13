<?php

namespace App\Http\Controllers\Admin;

use App\pCategory;
use App\post;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('posts');
        $categories = pCategory::all();
        return view('admin.posts.create', [
            'categories' => $categories,
        ]);
    }

    private function postValidation(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'picture' => ['required'],
            'categories' => ['required', 'array', 'present'],
            'categories.*' => ['required', 'exists:p_categories,id'],
        ]);
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
                imagepng($img, 'photos/' . 'cropped-' . $fileName);
            } else {
                $img = imagecreatetruecolor($sizes[1], $sizes[1]);
                imagesavealpha($img, true);
                $color = imagecolorallocatealpha($img, 0, 0, 0, 127);
                imagefill($img, 0, 0, $color);
                $a = imagecreatefromjpeg($image);
                imagecopyresampled($img, $a, ($sizes[1] - ($sizes[0] / $sizes[1]) * $sizes[1]) / 2, 0, 0, 0, ($sizes[0] / $sizes[1]) * $sizes[1], $sizes[1], $sizes[0], $sizes[1]);
                imagepng($img, 'photos/' . 'cropped-' . $fileName);
            }
            return 'photos/' . 'cropped-' . $fileName;

        } else {
            //take create image resources out of the 3 pngs we want to merge into destination image
            $a = imagecreatefromjpeg($image);
            $a = imagerotate($a, 360, 0);
            list($width, $height) = getimagesize($image);
            if ($width / $height >= 1)
                imagecopyresampled($dest_image, $a, 0, (HEIGHT2 - ($height / $width) * WIDTH2) / 2, 0, 0, WIDTH2, ($height / $width) * WIDTH2, $width, $height);
            else
                imagecopyresampled($dest_image, $a, (WIDTH2 - ($width / $height) * HEIGHT2) / 2, 0, 0, 0, ($width / $height) * HEIGHT2, HEIGHT2, $width, $height);
            imagejpeg($dest_image, 'photos/' . 'cropped-' . $fileName, 100);
            return 'photos/' . 'cropped-' . $fileName;
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('posts');
        $validate = $this->postValidation($request);
        if ($validate->fails())
            return back()->withErrors($validate, 'failed')->withInput();
        DB::beginTransaction();
        try {
            $post = new post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->picture = $request->picture;
            $post->thumbnail_picture = $this->smallPicture( public_path($post->picture) , explode('/', $post->picture )[count(explode('/', $post->picture )) - 1],243,150);
            $post->save();
            $post->categories()->sync($request->categories);
        } catch (QueryException $exception) {
            DB::rollBack();
            return back()->withErrors($exception->getMessage(), 'failed')->withInput();
        }
        DB::commit();
        return redirect(route('admin.posts.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }


    /**
     * @param post $post
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(post $post)
    {
        $this->authorize('posts');
        $categories = pCategory::all();
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * @param post $post
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(post $post, Request $request)
    {
        $this->authorize('posts');
        $validate = $this->postValidation($request);
        if ($validate->fails())
            return back()->withErrors($validate, 'failed')->withInput();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->picture = $request->picture;
        $post->thumbnail_picture = $this->smallPicture(public_path($post->picture ), explode('/', $post->picture )[count(explode('/', $post->picture )) - 1],243,150);
        $post->save();
        $post->categories()->sync($request->categories);
        return redirect(route('admin.posts.index'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('posts');
        $posts = post::latest()->get();
        return view('admin.posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * @param post $post
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(post $post)
    {
        $this->authorize('posts');
        $post->delete();
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
