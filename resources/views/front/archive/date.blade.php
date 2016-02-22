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
                    <a href="javascript:void(0)" class="col l3 m4 s4 date-month" target-list="{!! $yearKey . '-' . $monthKey !!}">
                        <blockquote>
                            <p class="num">{!! $monthKey !!}</p>
                            <p class="en">{!! intToMonth($monthKey) !!}</p>
                        </blockquote>
                    </a>

                @endforeach
            </div>
            @foreach($year as $monthKey => $month)
                <div class="col s12 post-list" id="{!! $yearKey . '-' . $monthKey !!}" style="display: none">
                    @include('front.archive.postList', ['title' => intToMonth($monthKey), 'posts' => $month, 'color' => 'orange'])
                </div>
            @endforeach
        @endforeach
    </div>

@stop

@section('script')
    <script>
        $('nav').addClass('orange');
        $('.side-nav').addClass('orange');
        $('.top-tags > a').addClass('orange');
        $('.collapsible-according').addClass('orange');

        $('.date-month').click(function(){
            var target = $(this).attr('target-list');
            $('html, body').animate({
                scrollTop: $('#' + target).parent().offset().top + 100
            }, 100);
        });
    </script>
@stop