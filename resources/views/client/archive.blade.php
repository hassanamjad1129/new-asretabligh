@extends('client.layout.master')
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
        <div class="col-md-9" id="posts">
            @foreach($posts as $key=>$post)
                @if(!$key)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <center>
                                    <img src="{{ asset($post->picture) }}"
                                         style="width: 80%;border-radius: 1rem;box-shadow: 0 0 5px rgba(0,0,0,.1)"
                                         alt="">
                                </center>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-xs-12" style="    line-height: 2.2rem;">
                                <a href="{{ route('post.detail',[$post->id,$newPost->title]) }}"><h2
                                            style="font-size: 2rem;margin-bottom: 1rem;margin-top: 1rem">{{ $post->title }}</h2>
                                </a>
                                {!! mb_substr(htmlspecialchars_decode(strip_tags($post->description)),0,250,"UTF-8")."..." !!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                @else
                    <div class="col-md-6"
                         @if($key%2)
                         style="padding-right: 0"
                         @else
                         style="padding-left: 0"
                            @endif>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-4" style="padding: 0">
                                    <img src="{{ asset($post->picture) }}" style="width: 100%" alt="">
                                </div>
                                <div class="col-md-8" style="padding: 0">
                                    <h2 style="margin-right: 4px;font-size: 1rem">
                                        <a href="{{ route('post.detail',[$post->id,$newPost->title]) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p style="margin-top: 3px;margin-right: 4px;text-align: justify">
                                        <small>{{ mb_substr(html_entity_decode(strip_tags($post->description)),0,195,"UTF-8")."..."}}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="clearfix"></div>
            {{ $posts->links() }}
        </div>
    </div>
@endsection