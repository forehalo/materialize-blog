<div id="view">
    {!! Form::open(['method' => 'post', 'url' => 'settings/view']) !!}
    <div class="card">
        <div class="card-content">
            <span class="card-title">Pagination</span>
            {!! formText('s8', 'post_per_page', 'post', $errors, 'Posts count per page', '', true, $config['post_per_page']) !!}
            {!! formText('s8', 'post_per_page_admin', 'post_admin', $errors, 'Posts count per page in dashboard', '', true, $config['post_per_page_admin']) !!}
            {!! formText('s8', 'comment_per_page_admin', 'comment', $errors, 'Comments count per page in dashboard', '', true, $config['comment_per_page_admin']) !!}
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Visibility</span>
            {!! formText('s8', 'hot_tags_count', 'tags', $errors, 'Hot tags count shown', '', true, $config['hot_tags_count']) !!}
            {!! Form::submit('update view', ['class' => 'btn wave-effect']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
