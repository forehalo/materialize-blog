@extends('front.template')
@section('title')
    <title>Tags</title>
@stop

@section('main')
    <h5 class="center page-title"><strong>Tags</strong></h5>
    <div class="divider"></div>
    <div class="input-field right">
        <select id="tag-order">
            <option value="" disabled selected>Select Order</option>
            <option value="1" class="blue-text">Hot</option>
            <option value="2" class="blue-text">Post Count</option>
            <option value="3" class="blue-text">Date</option>
        </select>
    </div>
    <div class="row">
        <div class="col s12 tag-list">
            @foreach($tags as $tag)
                <a href="javascript:void(0)" class="chip tag-chip pink accent-1" hot="{!! $tag->hot !!}" count="{!! $tag->posts()->count() !!}"
                     date="{!! $tag->created_at !!}">{!! $tag->name !!}</a>
            @endforeach
        </div>
    </div>
    <div class="row">
        @foreach($tags as $tag)
            <div id="{!! $tag->name !!}" class="col s12 post-list active" @if(!session('default') || session('default')->id != $tag->id)style="display: none"@endif>
                @include('front.archive.postList', ['title' => $tag->name, 'posts' => $tag->posts()->wherePublished(true)->get(), 'color' => 'pink'])
            </div>
        @endforeach
    </div>
@stop

@section('script')
    <script>
        $('nav').addClass('pink');
        $('.side-nav').addClass('pink');
        $('.collapsible-according').addClass('pink');

        // Hot desc
        var byHot = function (a, b) {
            return parseInt($(a).attr('hot')) > parseInt($(b).attr('hot')) ? -1 : 1;
        };
        // Count desc
        var byCount = function (a, b) {
            return parseInt($(a).attr('count')) > parseInt($(b).attr('count')) ? -1 : 1;
        };
        // Date desc
        var byDate = function (a, b) {
            return $(a).attr('date') > $(b).attr('date') ? -1 : 1;
        };

        var sortBySelect = function (rule) {
            var sortElements = $('a.tag-chip').sort(rule);
            $('.tag-list').fadeOut(400, function () {
                $(this).empty().append(sortElements).fadeIn();
            });
        };

        $('#tag-order').on('change', function () {
            switch ($('option:selected').val()) {
                case '1':
                    sortBySelect(byHot);
                    break;
                case '2':
                    sortBySelect(byCount);
                    break;
                case '3':
                    sortBySelect(byDate);
                    break;
            }

        });

        $('.tag-chip').click(function(){
            $('html, body').animate({
                scrollTop: $('.post-list').parent().offset().top - 100
            }, 100);
        });
    </script>
@stop