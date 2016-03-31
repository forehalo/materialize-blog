<ul class="side-nav fixed z-depth-4" id="nav-mobile" style="width: 240px">
    <li class="bold {!! classActivePath('dashboard') !!}">
        <a href="{!! url('/dashboard') !!}">Dashboard<i class="material-icons left">dashboard</i></a>
    </li>
    <li class="no-padding {!! classActiveSegment(1, 'posts') !!}">
        <ul class="collapsible collapsible-accordion">
            <li class="bold">
                <a class="collapsible-header no-scroll">Posts <i class="material-icons left">create</i><i
                            class="material-icons right">&#xE315;</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{!! url('posts/admin') !!}">All</a></li>
                        <li><a href="{!! url('posts/create') !!}">New</a></li>
                        <li><a href="{!! url('posts/file') !!}">From Files</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li class="bold {!! classActivePath('comments') !!}"><a href="{!! url('/comments') !!}" class="waves-effect">Comments<i class="material-icons left">comment</i></a></li>
{{--    <li class="bold {!! classActivePath('messages') !!}"><a href="{!! url('/messages') !!}" class="waves-effect">Messages<i class="material-icons left">mail</i></a></li>--}}
    <li class="bold {!! classActivePath('settings') !!}"><a href="{!! url('/settings') !!}" class="waves-effect">Settings<i class="material-icons left">settings</i></a></li>
</ul>
@if(!(Request::is('posts/create') || Request::is('posts/*/edit')))
<a href="{!! url('posts/create') !!}" class="btn-floating btn-large waves-effect waves-light blue fixed tooltipped" data-position="left" data-delay="50" data-tooltip="Create"><i
            class="material-icons">mode_edit</i></a>
    @endif