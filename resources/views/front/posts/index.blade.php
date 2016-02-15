@extends('front.template')
@section('title')
    <title>{!! setting('title') !!}</title>
@stop

@section('main')

    <h5>共 {!! $posts->total() !!} 篇</h5>
    <div class="divider"></div>
    <ul class="collapsible popout" data-collapsible="accordion" id="article">
        @foreach($posts as $post)
            <li>
                <div class="collapsible-header no-seen" id="post-{!! $post->id !!}" pageY="">
                    <h5 id="title">{!! $post->title !!}</h5>
                    <div class="label">published at {!! substr($post->created_at, 0, 10) !!}
                        <i class="material-icons">visibility</i>{!! $post->view_count !!}
                        <i class="material-icons">comment</i>{!! $post->comment_count !!}
                        <a href="javascript:void(0)" class="grey-text favorite-btn" id="favorite-{!! $post->id !!}"><i class="material-icons">favorite_border</i><span>{!! $post->favorite_count !!}</span></a>
                    </div>
                    <p class="summary">{!! $post->summary !!}</p>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            @foreach($post->tags as $tag)
                                <div class="chip">{!! $tag->name !!}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="collapsible-body">
                    <div class="divider"></div>
                    <div class="row post-right">
                        @include('front.components.postRight', ['id' => $post->id, 'slug' => $post->slug])
                    </div>
                    <div class="row comment-form">
                        @include('front.components.commentForm', ['id' => $post->id, 'slug' => $post->slug, 'viewButton' => true])
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {!! $links !!}
@stop

@section('script')
    <script>
        $('nav').addClass('blue');
        $('.top-tags > a').addClass('blue');
        $('.side-nav').addClass('blue');
        $('.collapsible-according').addClass('blue');

        $(document).on('click', '.no-seen', function () {
            var id = $(this).attr('id');
            var header = $('#' + id);
            var body = header.next();
            $(progressDiv).appendTo(header);

            $.ajax({
                url: '{!! url('/posts') !!}' + '/' + id.substr(5) + '/body',
                type: 'get'
            }).done(function (data) {
                header.removeClass('no-seen').addClass('seen');
                $('#progressDiv').remove();
                body.prepend('<div class="article-content markdown-body">' + data.body + '</div>');
                Prism.highlightAll();
            }).fail(function () {
                Materialize.toast('Fetch article body failed!', 3000);
                $('#progressDiv').remove();
                hideActiveHeader(header);
            });
        });
    </script>
@stop