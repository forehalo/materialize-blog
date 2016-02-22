@extends('front.template')
@section('title')
    <title>{!! $post->title . ' - ' . setting('title') !!}</title>
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
                            <a href="#comments" class="grey-text"><i class="material-icons">comment</i>{!! $post->comment_count !!}</a>
                            <a href="javascript:void(0)" class="grey-text favorite-btn" id="favorite-{!! $post->id !!}"><i class="material-icons">favorite_border</i><span>{!! $post->favorite_count !!}</span></a>
                        </div>
                    </div>
                </div>
                <div class="article-content markdown-body">{!! $post->body !!}</div>
                <div class="card-action">
                    <div class="row">
                        <div class="col s12 l6">
                            <h5 class="inline">category :</h5> <a
                                    href="{!! url('/categories/' . $post->category->id) !!}"
                                    class="chip tag-chip">{!! $post->category->name !!}</a>
                        </div>
                        <div class="col s12 l6">
                            <h5 class="inline">tags :</h5>
                            @foreach($post->tags as $tag)
                                <a href="{!! url('/tags/' . $tag->id ) !!}" class="chip tag-chip">{!! $tag->name !!}</a>
                            @endforeach
                        </div>
                        <div class="col s12 post-right">
                            @include('front.components.postRight', ['id' => $post->id, 'slug' => $post->slug])
                        </div>
                    </div>
                    <div class="row">
                        @include('front.components.commentForm', ['id' => $post->id, 'slug' => $post->slug, 'viewButton' => false])
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-depth-3">
            <div class="card-content comment-list" id="comments">
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('nav').addClass('blue');
        $('.side-nav').addClass('blue');
        $('.top-tags > a').addClass('blue');

        // Fetch post comments
        var fetchComments = function () {
            var commentList = $('.comment-list');
            commentList.append(progressDiv);
            $.ajax({
                url: "{!! url('/posts/' . $post->id . '/comments') !!}",
                type: "get"
            }).done(function (data) {
                $("#progressDiv").remove();

                if (data.length == 0) {
                    commentList.append('<div><h5>No comment</h5></div>');
                } else {
                    for (var i = 0; i < data.length; ++i) {
                        var comment = data[i];
                        var string = '<div id="comment-' + comment.id + '"><a href="' + comment.blog + '" class="comment-title"><i class="material-icons">person</i>' + comment.name + '</a><span> | ' + comment.created_at + ' : </span><a href="javascript:void(0)" class="reply-btn tooltipped" data-position="right" data-delay="50" data-tooltip="reply"><i class="material-icons" style="top: 6px;">reply</i></a> <div class="row"> <div class="markdown-body">';
                        if (comment.parent_id !== 0) {
                            string += 'reply <a href="javascript:void(0)" class="reply " pre-comment="' + comment.parent_id + '">@' + comment.parent_name + '</a> :<br/>'
                        }
                        string += (comment.content + '</div> </div> <div class="divider"></div> </div></div>');
                        commentList.append(string);
                    }
                    // init tooltip
                    $('.tooltipped').tooltip({delay: 50});

                    $(".reply").on("click", function () {
                        var pre_comment = $("#comment-" + $(this).attr("pre-comment"));
                        var pxToTop = pre_comment.offset().top;
                        $("html, body").animate({scrollTop: pxToTop - 100}, 100);
                        pre_comment.css("background", "#DDD");
                        pre_comment.animate({background: "#FFF"}, 2000, function () {
                            pre_comment.css("background", "#FFF")
                        });
                    });

                    $(".reply-btn").on("click", function () {
                        var hidden = $("input[name=\"parent\"]");
                        hidden.attr("value", $(this).parent().attr("id").substr(8));
                        $("html, body").animate({scrollTop: hidden.parent().offset().top - 100}, 100);
                    });

                    Prism.highlightAll($('.comment-list > .markdown-body').html());
                }
            }).fail(function () {
                $("#progressDiv").remove();
                Materialize.toast("Fetch Comments Failed", 3000);
            });
        };

        var options = [
            {
                selector: '.comment-list',
                offset: 0,
                callback: funcToString(fetchComments)
            }
        ];
        Materialize.scrollFire(options);

        @if(session('errors'))
            Materialize.toast('{!! 'Something goes wrong' !!}', 3000);
        @endif

        @if(session('ok'))
            Materialize.toast('{!! session('ok') !!}', 3000);
        @endif
    </script>
@stop

