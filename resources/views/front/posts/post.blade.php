@extends('front.template')
@section('title')
    <title>{!! $post->title !!}</title>
@stop

@section('main')
    <div class="row the-article">
        <div class="card z-depth-3">
            <div class="card-content">
                <h5 class="article-title">{!! $post->title !!}</h5>
                <div class="article-info">
                    <div class="label">
                        <div class="col s12 l8">
                            published at {!! substr($post->created_at, 0, 10) !!} by Forehalo
                        </div>
                        <div class="col s12 l4">
                            <i class="material-icons">visibility</i>{!! $post->view_count !!}
                            <i class="material-icons">comment</i>{!! $post->comment_count !!}
                            <i class="material-icons">favorite</i>{!! $post->favorite_count !!}
                        </div>
                    </div>
                </div>
                <div class="article-content markdown-body">{!! $post->body !!}</div>
                <div class="divider"></div>
                <div class="card-action">
                    <div class="row">
                        <div class="col s12 l6">
                            <h5 class="inline">category :</h5> <a href="{!! url('/categories/' . $post->category->id) !!}" class="chip tag-chip">{!! $post->category->name !!}</a>
                        </div>
                        <div class="col s12 l6">
                            <h5 class="inline">tags :</h5>
                            @foreach($post->tags as $tag)
                                <a href="{!! url('/tags/' . $tag->id ) !!}" class="chip tag-chip">{!! $tag->name !!}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        @include('front.components.commentForm', ['id' => $post->id])
                    </div>
                </div>
            </div>

        </div>

    </div>
@stop

@section('script')
    <script>
        $('nav').addClass('blue');
        $('.side-nav').addClass('blue');
        $('.top-tags > a').addClass('blue');
    </script>
    @stop

