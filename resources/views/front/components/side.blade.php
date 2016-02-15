@inject('links', 'App\Models\Link')
@inject('tags', 'App\Models\Tag')
<div class="row">
    <div class="col m12 l12 hide-on-small-and-down">

        <h5>Info</h5>
        <div class="divider"></div>
        <div class="card">
            <div class="card-image">
                {!! Html::image('assets/image/sample-1.jpg') !!}
                <span class="card-title">{!! config('blog.card_title') !!}</span>
            </div>
            <div class="card-content">
                <p>{!! config('blog.notice') !!}</p>
            </div>
            <div class="card-action">
                <a href="mailto:{!! config('blog.email') !!}" class="btn btn-flat waves-effect">Email</a>
                <a href="{!! 'http://' . config('blog.github') !!}" class="btn btn-flat waves-effect" target="_blank">Github</a>
                <a href="{!! 'http://' . config('blog.weibo') !!}" class="btn btn-flat waves-effect" target="_blank">Weibo</a>
            </div>
        </div>
        <div class="divider"></div>

        @if(!Request::is('tags'))
        <h5>Tags</h5>
        <div class="row">
            <div class="col m12 l12 top-tags">
                @foreach($tags::select('id', 'name')
                                ->take(10)
                                ->orderBy('hot', 'desc')
                                ->get() as $tag)
                    <a href="{!! url('/tags/'. $tag->id) !!}" class="btn waves-effect">{!! $tag->name !!}</a>
                @endforeach
            </div>
        </div>
        <div class="divider"></div>
        @endif

        <h5>Friend Links</h5>
        <div class="friend-links col m12 l12">
            <ul>
                @foreach($links::all() as $link)
                    <li><a href="{!! $link->link !!}" class="btn btn-flat truncate"><i
                                    class="material-icons left black-text">face</i>{!! $link->name !!}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>