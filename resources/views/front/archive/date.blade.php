@extends('front.template')
@section('title')
    <title>Date</title>
@stop

@section('main')
    <h5 class="center page-title"><strong>Date</strong></h5>
    <div class="divider"></div>
    <div class="row date-group">
        @foreach($group as $yearKey => $year)
            <h4 class="date-year">{!! $yearKey !!}</h4>
            <div class="row">
                @foreach($year as $monthKey => $month)
                    <div class="col l3 m4 s4 date-month" target-list="{!! $yearKey . '-' . $monthKey !!}">
                        <blockquote>
                            <p class="num">{!! $monthKey !!}</p>
                            <p class="en">{!! intToMonth($monthKey) !!}</p>
                        </blockquote>
                    </div>

                @endforeach
                @foreach($year as $monthKey => $month)
                    <div class="col s12 post-list" id="{!! $yearKey . '-' . $monthKey !!}" style="display: none">
                        <ul class="collection with-header">
                            <li class="collection-header orange lighten-5"><h5>{!! intToMonth($monthKey) !!}</h5></li>
                            @foreach($month as $post)
                                <a href="{!! url('/lists/' . $post->slug) !!}" class="collection-item orange-text">
                                    {!! $post->title !!}
                                    <i class="material-icons right">send</i>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

@stop

@section('script')
    <script>
        $('nav').addClass('orange');
        $('.side-nav').addClass('orange');
        $('.top-tags > a').addClass('orange');
        $('.post-list > ul > a').css('opacity', 0);
    </script>
@stop