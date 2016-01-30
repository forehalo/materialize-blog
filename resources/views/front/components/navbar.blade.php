@inject('cates', 'App\Models\Category')
<div class="navbar-fixed">
    <nav>
        <div class="container">
            <div class="nav-wrapper">
                {{--mobile device memu--}}
                <a href="#" data-activates="nav-mobile"
                   class="button-collapse waves-effect btn-flat btn-floating"><i
                            class="material-icons">menu</i></a>
                <a href="/" class="brand-logo">// Forehalo</a>
                <ul class="hide-on-med-and-down nav-items">
                    <li><a href="/" class="waves-effect waves-block"><i
                                    class="material-icons left">list</i>Posts</a>
                    </li>
                    <li><a href="#" class="waves-effect waves-block dropdown-button" data-activates="cate_drop_top">Categories<i
                                    class="material-icons left">class</i><i
                                    class="material-icons right">arrow_drop_down</i></a>
                        <ul id="cate_drop_top" class="dropdown-content">
                            @foreach($cates::orderBy('hot', 'desc')->get() as $cate)
                                <li><a href="{!! url('/categories/' . $cate->name) !!}">{!! $cate->name !!}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="#" class="waves-effect waves-block dropdown-button" data-activates="archive_drop">Archives<i
                                    class="material-icons left">label_outline</i><i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="archive_drop" class="dropdown-content">
                            <li><a href="#" class="black-text disabled">Group By</a></li>
                            <li class="divider"></li>
                            <li><a href="{!! url('categories') !!}" class="green-text">Categories</a></li>
                            <li><a href="{!! url('tags') !!}" class="pink-text">Tags</a></li>
                            <li><a href="{!! url('date') !!}" class="orange-text">Date</a></li>
                        </ul>
                    </li>
                    <li><a href="{!! url('about') !!}" class="waves-effect waves-block">About<i
                                    class="material-icons left">perm_identity</i></a></li>
                    <li>
                        <a class=""><i class="material-icons">search</i></a>
                    </li>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li><a href="/" class="waves-effect waves-teal white-text">Posts<i class="material-icons left">list</i></a></li>
                    <li><a href="#" class="waves-effect waves-block dropdown-button white-text" data-activates="cate_drop_side">Categories<i
                                    class="material-icons left">class</i><i
                                    class="material-icons right">arrow_drop_down</i></a>
                        <ul id="cate_drop_side" class="dropdown-content">
                            @foreach($cates::orderBy('hot', 'desc')->get() as $cate)
                                <li><a href="{!! url('/categories/' . $cate->name) !!}">{!! $cate->name !!}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="#" class="waves-effect waves-block dropdown-button white-text" data-activates="archive_drop_side">Archives<i
                                    class="material-icons left">label_outline</i><i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="archive_drop_side" class="dropdown-content">
                            <li><a href="#" class="black-text disabled">Group By</a></li>
                            <li><a href="{!! url('categories') !!}" class="green-text">Categories</a></li>
                            <li><a href="{!! url('tags') !!}" class="pink-text">Tags</a></li>
                            <li><a href="{!! url('date') !!}" class="orange-text">Date</a></li>
                        </ul>
                    </li>
                    <li><a href="{!! url('about') !!}" class="waves-effect waves-teal white-text">About <i class="material-icons left">perm_identity</i></a></li>
                    <li>
                        <div class="input-field">
                            <input id="search" type="search" required>
                            <label for="search"><i class="material-icons">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>