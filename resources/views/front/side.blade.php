@inject('links', 'App\Models\Link')
@inject('tags', 'App\Models\Tag')
<div class="row">
    <div class="col m12 l12 hide-on-small-and-down">

        <h5>Info</h5>
        <div class="divider"></div>
        <div class="card">
            <div class="card-image">
                {!! html::image('assets/image/sample-1.jpg') !!}
                <span class="card-title">{!! config('blog.card_title') !!}</span>
            </div>
            <div class="card-content">
                <p>{!! config('blog.person') !!}</p>
            </div>
            <div class="card-action">
                <a href="mailto:{!! config('blog.email') !!}" class="btn btn-flat waves-effect">Email</a>
                <a href="{!! config('blog.github') !!}" class="btn btn-flat waves-effect" target="_blank">Github</a>
                <a href="{!! config('blog.weibo') !!}" class="btn btn-flat waves-effect" target="_blank">Weibo</a>
            </div>
        </div>
        <div class="divider"></div>

        <h5>Tags</h5>
        <div class="row top-tags">
            <div class="col m12 l12">
                @foreach($tag::select('id', 'name', 'hot')
                                ->take(10)
                                ->orderBy('hot', 'desc')
                                ->get() as $item)
                    <a href="#" class="btn waves-effect">{!! $item->name !!}</a>
                @endforeach
            </div>
        </div>
        <div class="divider"></div>


        <h5>Friend Links</h5>
        <div class="friend-links col m12 l12">
            <ul>
                @foreach($links::all() as $item)
                    <li><a href="{!! $item->link !!}" class="btn btn-flat truncate"><i
                                    class="material-icons left black-text">face</i>{!! $item->name !!}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>