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
                <ul class="collection with-header ">
                    <li class="collection-header"><h5>{!! $category->name !!}</h5></li>
                    @foreach($category->posts as $post)
                        <a href="{!! url('/lists/' . $post->slug) !!}" class="collection-item">
                            {!! $post->title !!}
                            <i class="material-icons right">send</i>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@stop