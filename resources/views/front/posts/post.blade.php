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
                    </div>
                    <div class="row">
                        @include('front.components.commentForm', ['id' => $post->id])
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-depth-3">
            <div class="card-content comment-list">
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $('nav').addClass('blue');
        $('.side-nav').addClass('blue');
        $('.top-tags > a').addClass('blue');
        {{--var fetchComments = function () {--}}
            {{--$(".comment-list").append(progressDiv);--}}
            {{--$.ajax({--}}
                {{--url: "{!! url("/posts/" . $post->id . "/comments") !!}",--}}
                {{--type: "get"--}}
            {{--}).done(function (data) {--}}
                {{--$("#progressDiv").remove();--}}
                {{--for (var i = 0; i < data.length; ++i) {--}}
                    {{--var comment = data[i];--}}

                    {{--var string = '<div><a href="' + comment.blog +  '" class="comment-title" id="comment-' + comment.id + '"><i class="material-icons">person</i>' + comment.name + '</a><span> | ' + comment.created_at + ' : </span> <div class="row"> <div class="markdown-body">';--}}
                    {{--if(comment.parent_id !== 0){--}}
                        {{--string += 'reply <a href="javascript:void(0)" class="reply" pre-comment="' + comment.parent_id + '">@' + comment.parent_name + '</a> :<br/>'--}}
                    {{--}--}}
                    {{--string += comment.content + '</div> </div> <div class="divider"></div> </div></div>';--}}

                    {{--$(".comment-list").append(string);--}}

                {{--}--}}
            {{--}).fail(function () {--}}
                {{--$("#progressDiv").remove();--}}
                {{--Materialize.toast("Fetch Comments Failed", 3000);--}}
            {{--});--}}
        {{--};--}}
        var options = [
            {
                selector: '.comment-list',
                offset: 0,
                callback: '$(".comment-list").append(progressDiv);$.ajax({url: "{!! url("/posts/" . $post->id . "/comments") !!}", type: "get"}).done(function (data) {$("#progressDiv").remove();for (var i = 0; i < data.length; ++i) {var comment = data[i];var string = \'<div><a href="\' + comment.blog +  \'" class="comment-title" id="comment-\' + comment.id + \'"><i class="material-icons">person</i>\' + comment.name + \'</a><span> | \' + comment.created_at + \' : </span> <div class="row"> <div class="markdown-body">\';if(comment.parent_id !== 0){string += \'reply <a href="javascript:void(0)" class="reply" pre-comment="\' + comment.parent_id + \'">@\' + comment.parent_name + \'</a> :<br/>\'}string += (comment.content + \'</div> </div> <div class="divider"></div> </div></div>\');$(".comment-list").append(string);}         $(".reply").on("click", function () {var pre_comment = $("#comment-" + $(this).attr("pre-comment"));var pxToTop = pre_comment.offset().top;$("html, body").animate({scrollTop: pxToTop - 100}, 100);pre_comment.parent().css("background", "#DDD");pre_comment.parent().animate({background: "#FFF"}, 2000, function () {pre_comment.parent().css("background", "#FFF")});});}).fail(function () {$("#progressDiv").remove();Materialize.toast("Fetch Comments Failed", 3000);});'
            }
        ];
        Materialize.scrollFire(options);
    </script>
@stop

