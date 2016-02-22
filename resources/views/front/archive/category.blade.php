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
                    <li class="tab">
                        <a href="{!! '#'.$category->name !!}"
                           class="green-text @if(session('default') && session('default')->id == $category->id) active @endif">
                            {!! $category->name !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        @foreach($categories as $category)
            <div id="{!! $category->name !!}" class="col s12 post-list">
                @include('front.archive.postList', ['title' => $category->name, 'posts' => $category->posts()->wherePublished(true)->orderBy('created_at', 'desc')->get(), 'color' => 'green'])
            </div>
        @endforeach
    </div>
@stop

@section('script')
    <script>
        $('nav').addClass('green lighten-1');
        $('.side-nav').addClass('green lighten-1');
        $('.top-tags > a').addClass('green lighten-1');
        $('.collapsible-according').addClass('green lighten-1');

    </script>
@stop