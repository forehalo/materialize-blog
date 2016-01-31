<ul class="collection with-header">
    <li class="collection-header orange lighten-5"><h5>{!! $title !!}</h5></li>
    @foreach($posts as $post)
        <a href="{!! url('/posts/' . $post->slug) !!}" class="collection-item orange-text">
            <div class="row">
            <div class="col s11 m11 l11 truncate">{!! $post->title !!}</div>
            <div class="col s1 m1 l1"><i class="material-icons">send</i></div>
            </div>
        </a>
    @endforeach
</ul>