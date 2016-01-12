<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {!! Html::style('assets/css/materialize.min.css', ['media' => 'screen,projection']) !!}
    {!! Html::style('assets/css/forehalo.css') !!}
    {!! Html::style('assets/css/markdown.min.css') !!}
    {!! Html::style('assets/css/prism.css') !!}
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @yield('title')
</head>
<body>
<header>
    @include('front.navbar')
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m9 l10">
                @yield('main')
            </div>
            <div class="col hide-on-small-only m3 l2">
                @include('front.side')
            </div>
        </div>
    </div>
</main>

@include('front.footer')

{!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
{!! Html::script('assets/js/materialize.min.js') !!}
{!! Html::script('assets/js/init.js') !!}
{!! Html::script('assets/js/marked.min.js') !!}
{!! Html::script('assets/js/forehalo.js') !!}
@yield('script')
</body>
</html>