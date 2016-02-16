<div id="profile">
    {!! Form::open(['method' => 'post', 'url' => 'settings/profile']) !!}
    <div class="card">
        <div class="card-content">
            <span class="card-title">Basic</span>
            {!! formText('s8', 'title', 'title', $errors, 'title', 'subtitles', true, $config['title']) !!}
            {!! formText('s8', 'name', 'name', $errors, 'name', 'person', true, $config['name']) !!}
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Information card</span>
            {!! formText('s8', 'card-title', 'card-title', $errors, 'card title', '', true, $config['card_title']) !!}
            {!! formText('s8', 'notice', 'notice', $errors, 'card notice', '', true, $config['notice']) !!}
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Site</span>
            {!! formText('s8', 'description', 'description', $errors, 'site description', 'description', true, $config['description']) !!}
            {!! formText('s8', 'url', 'url', $errors, 'url', 'web', true, $config['url']) !!}
            {!! Form::submit('update profile', ['class' => 'btn wave-effect']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>