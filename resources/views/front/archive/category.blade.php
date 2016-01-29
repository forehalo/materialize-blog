@extends('front.template')
@section('title')
    <title>Categories</title>
@stop

@section('main')
    <h5 class="center"><strong>Categories</strong></h5>
    <div class="divider"></div>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                @foreach($categories as $category)
                    <li class="tab"><a href="{!! '#'.$category->name !!}">{!! $category->name !!}</a></li>
                @endforeach
            </ul>
        </div>
        @foreach($categories as $category)
            <div id="{!! $category->name !!}" class="col s12">
                <ul class="collapsible" data-collapsible="accordion" id="article">
                    @foreach($category->posts as $post)
                        <li>
                        <div class="collapsible-header" id="post-{!! $post->id !!}" PageY="">
                            <h5 id="title">{!! $post->title !!}</h5>
                            <div class="label">published at {!! $post->created_at !!}
                                <i class="material-icons">visibility</i>{!! $post->view_count !!}
                                <i class="material-icons">comment</i>{!! $post->comment_count !!}
                            </div>
                            <p class="summary">{!! $post->summary !!}</p>
                        </div>
                        <div class="collapsible-body markdown-body">
                            {!! $post->body !!}
                        </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@stop