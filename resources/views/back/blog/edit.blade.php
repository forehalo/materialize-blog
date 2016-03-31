@extends('back.blog.post_form')
@section('title')
    <title>Edit Post</title>
@stop

@section('form-header')
    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'put',  'class' => 'col s12']) !!}
@stop