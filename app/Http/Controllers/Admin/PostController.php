<?php

namespace App\Http\Controllers\Admin;

use App\pCategory;
use App\post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create()
    {
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

    public function store(Request $request)
    {
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


    public function edit(post $post)
    {
        $categories = pCategory::all();
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    public function update(post $post, Request $request)
    {
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

    public function index()
    {
        $posts = post::latest()->get();
        return view('admin.posts.index', [
            'posts' => $posts
        ]);
    }

    public function destroy(post $post)
    {
        $post->delete();
        return back()->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
