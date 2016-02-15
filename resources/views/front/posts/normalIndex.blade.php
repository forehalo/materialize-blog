@extends('front.template')
@section('title')
    <title>{!! setting('title') !!}</title>
@stop

@section('main')
    <h5>共 {!! $posts->total() !!} 篇</h5>
    <div class="divider"></div>
    <div class="collection z-depth-3">
        @foreach($posts as $post)
            <div class="collection-item">
                <a href="{!! url('/posts/' . $post->slug) !!}"><h5>{!! $post->title !!}</h5></a>
                <div class="label">published at {!! substr($post->created_at, 0, 10) !!}
                    <i class="material-icons">visibility</i>{!! $post->view_count !!}
                    <i class="material-icons">comment</i>{!! $post->comment_count !!}
                    <i class="material-icons">favorite_border</i>{!! $post->favorite_count !!}
                </div>
                <p class="summary">{!! $post->summary !!}</p>
                <div class="row">
                    <div class="col s12 m12 l12">
                        @foreach($post->tags as $tag)
                            <a href="{!! url('/tags/' . $tag->id) !!}" class="chip">{!! $tag->name !!}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {!! $links !!}
@stop

@section('script')
    <script>
        $('nav').addClass('blue');
        $('.top-tags > a').addClass('blue');
        $('.side-nav').addClass('blue');
        $('.collapsible-according').addClass('blue');
    </script>
@stop