<div id="link" class="col s12 l8">
    {!! Form::open(['method' => 'post', 'url' => 'settings/link']) !!}
    <div class="card">
        <div class="card-content">
            <span class="card-title">Profile links</span>
            <div class="row">
                {!! formText('s12 l8', 'email', 'email', $errors, 'email', '', true, $config['email']) !!}
                {!! formText('s12 l8', 'github', 'github', $errors, 'github', '', true, $config['github']) !!}
                {!! formText('s12 l8', 'weibo', 'weibo', $errors, 'weibo', '', true, $config['weibo']) !!}
            </div>
            {!! Form::button('Update link', ['type' => 'submit', 'class' => 'btn waves-effect']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
