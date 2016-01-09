@extends('front.template')
@section('title')
    <title>Forehalo 的博客</title>
@stop

@section('main')


    <h5>共 3 篇</h5>
    <div class="divider"></div>
    <ul class="collapsible popout" data-collapsible="accordion" id="article">
        <li>
            <div class="collapsible-header" id="1"><i class="material-icons">filter_drama</i><h4 id="title">laravel5 配合 Queues 使用 Artisan
                    Commands</h4><p class="intro">Laravel本身给我们提供了许多强大的Artisan命令，但这些都是基于框架的一些操作，有时我们也需要自己定制一些命令。接下来就介绍一下如何添加自己的命令，以及使用队列来执行命令。</p>
            </div>
            <div class="collapsible-body">
                <p>Laravel本身给我们提供了许多强大的Artisan 命令，但这些都是基于框架的一些操作，有时我们也需要自己定制一些命令。接下来就介绍一下如何添加自己的命令，以及使用队列来执行命令。</p>
            </div>
        </li>
        <li>
            <div class="collapsible-header" id="2"><i class="material-icons">place</i>foreach 循环中注意事项<p class="intro">Laravel本身给我们提供了许多强大的Artisan命令，但这些都是基于框架的一些操作，有时我们也需要自己定制一些命令。接下来就介绍一下如何添加自己的命令，以及使用队列来执行命令。</p></div>
            <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
        </li>
        <li>
            <div class="collapsible-header" id="3"><i class="material-icons">whatshot</i>Excel-Worker 一个 PHP 操作 excel 包<p class="intro">Laravel本身给我们提供了许多强大的Artisan命令，但这些都是基于框架的一些操作，有时我们也需要自己定制一些命令。接下来就介绍一下如何添加自己的命令，以及使用队列来执行命令。</p></div>
            <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
        </li>
    </ul>
    <ul class="pagination">
        <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
        <li class="active"><a href="#!">1</a></li>
        <li class="waves-effect"><a href="#!">2</a></li>
        <li class="waves-effect"><a href="#!">3</a></li>
        <li class="waves-effect"><a href="#!">4</a></li>
        <li class="waves-effect"><a href="#!">5</a></li>
        <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
    </ul>
@stop

@section('script')
    <script>
    </script>
@stop