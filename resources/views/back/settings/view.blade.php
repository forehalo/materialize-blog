<div id="view" class="col s12 l8">
    {!! Form::open(['method' => 'post', 'url' => 'settings/view']) !!}
    <div class="card">
        <div class="card-content">
            <span class="card-title">Pagination</span>
            <div class="row">
                {!! formText('s12 l6', 'post_per_page', 'post', $errors, 'Posts count per page', '', true, $config['post_per_page']) !!}
                {!! formText('s12 l6', 'post_per_page_admin', 'post_admin', $errors, 'Posts count per page in dashboard', '', true, $config['post_per_page_admin']) !!}
                {!! formText('s12 l6', 'comment_per_page_admin', 'comment', $errors, 'Comments count per page in dashboard', '', true, $config['comment_per_page_admin']) !!}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Visibility</span>
            <div class="row">
                {!! formText('s12 l6', 'hot_tags_count', 'tags', $errors, 'Hot tags count shown', '', true, $config['hot_tags_count']) !!}
            </div>
            {!! Form::button('update view', ['type' => 'submit', 'class' => 'btn waves-effect']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
