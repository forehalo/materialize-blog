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
                <li class="tab col s3"><a href="#test1">Test 1</a></li>
                <li class="tab col s3"><a class="active" href="#test2">Test 2</a></li>
                <li class="tab col s3 disabled"><a href="#test3">Disabled Tab</a></li>
                <li class="tab col s3"><a href="#test4">Test 4</a></li>
            </ul>
        </div>
        <div id="test1" class="col s12">aaaa</div>
        <div id="test2" class="col s12">Test 2</div>
        <div id="test3" class="col s12">Test 3</div>
        <div id="test4" class="col s12">Test 4</div>
    </div>
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
                <ul>
                    @foreach($category->posts as $post)
                        <li><a href="#">{!! $post->title !!}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
    {{--<div class="divider"></div>--}}

    {{--<div class="row">--}}
    {{--<ul class="collapsible" data-collapsible="accordion">--}}
    {{--@foreach($categories as $category)--}}
    {{--<li>--}}
    {{--<div class="collapsible-header">{!! $category->name !!}</div>--}}
    {{--<div class="collapsible-body">--}}
    {{--<ul>--}}
    {{--@foreach($category->posts as $post)--}}
    {{--<li><a href="#">{!! $post->title !!}</a></li>--}}
    {{--@endforeach--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</li>--}}
    {{--@endforeach--}}
    {{--</ul>--}}
    {{--</div>--}}
@stop