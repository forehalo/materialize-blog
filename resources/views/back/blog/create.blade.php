@extends('back.blog.post_form')
@section('title')
    <title>New Post</title>
@stop

@section('form-header')
    {!! Form::open(['method' => 'post', 'url' => url('/posts'), 'class' => 'col s12']) !!}
@stop