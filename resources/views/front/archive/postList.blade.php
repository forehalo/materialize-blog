<ul class="collection with-header">
    <li class="collection-header orange lighten-5"><h5>{!! $title !!}</h5></li>
    @foreach($posts as $post)
        <a href="{!! url('/posts/' . $post->slug) !!}" class="collection-item orange-text">
            {!! $post->title !!}
            <i class="material-icons right">send</i>
        </a>
    @endforeach
</ul>