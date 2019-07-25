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
