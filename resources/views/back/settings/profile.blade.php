<div id="profile" class="col s12 l8">
    {!! Form::open(['method' => 'post', 'url' => 'settings/profile']) !!}
    <div class="card">
        <div class="card-content">
            <span class="card-title">Basic</span>
            <div class="row">
                {!! formText('s12 l8', 'title', 'title', $errors, 'title', 'subtitles', true, $config['title']) !!}
                {!! formText('s12 l8', 'name', 'name', $errors, 'name', 'person', true, $config['name']) !!}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Information card</span>
            <div class="row">
                {!! formText('s12 l8', 'card_title', 'card-title', $errors, 'card title', '', true, $config['card_title']) !!}
                {!! formText('s12 l8', 'notice', 'notice', $errors, 'card notice', '', true, $config['notice']) !!}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Site</span>
            <div class="row">
                {!! formText('s12 l8', 'description', 'description', $errors, 'Site description', 'description', true, $config['description']) !!}
                {!! formText('s12 l8', 'keywords', 'keywords', $errors, 'Keywords', 'vpn_key', true, $config['keywords']) !!}
                {!! formText('s12 l8', 'url', 'url', $errors, 'URL', 'web', true, $config['url']) !!}
            </div>
            {!! Form::button('update profile', ['type' => 'submit', 'class' => 'btn waves-effect']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>