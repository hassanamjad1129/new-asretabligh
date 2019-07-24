@extends('client.layout.master')
@section('title'){{ $post->title }}@endsection
@section('content')
    <div class="container">
        <div class="col-md-3">
            <div class="panel panel-default" id="postCategories">
                <div class="panel-heading">
                    <h5>دسته بندی</h5>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($categories as $category)
                            <li><a href="">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="panel panel-default" id="postCategories">
                <div class="panel-heading">
                    <h5>جدیدترین مطالب</h5>
                </div>
                <div class="panel-body">
                    @foreach($newPosts as $newPost)
                        <div class="col-md-4" style="padding: 0">
                            <img src="{{ asset($newPost->picture) }}" style="width: 100%" alt="">
                        </div>
                        <div class="col-md-8" style="padding: 0">
                            <h5 style="margin-right: 4px">
                                <a href="{{ route('post.detail',[$newPost->id,$newPost->title]) }}">{{ $newPost->title }}</a>
                            </h5>
                            <p style="margin-top: 3px;margin-right: 4px;text-align: justify">
                                <small>{{ mb_substr(html_entity_decode(strip_tags($newPost->description)),0,80,"UTF-8")."..."}}</small>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="col-md-10">
                <img src="{{ asset($post->picture) }}"
                     style="width: 95%;border-radius: 1rem;box-shadow: 0 0 5px rgba(0,0,0,.1)" alt="">
            </div>
            <div class="col-md-2">
                <div class="seenBox">
                    <div class="seenBoxHeading"> {{ jdate(strtotime($post->created_at))->format('l') }}</div>
                    <div class="seenBoxBody">
                        {{ jdate(strtotime($post->created_at))->format('j F') }}
                    </div>
                </div>
                <div class="seenBox">
                    <div class="seenBoxHeading"> بازدید</div>
                    <div class="seenBoxBody">
                        <span>{{ $post->seen }}</span>
                        <span><i class="fa fa-eye"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12" style="    line-height: 2.2rem;">
                <h1 style="font-size: 2rem;margin-bottom: 1rem;margin-top: 1rem">{{ $post->title }}</h1>
                {!! $post->description !!}
            </div>
        </div>

    </div>
@endsection