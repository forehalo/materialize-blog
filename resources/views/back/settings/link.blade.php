@inject('friends', 'App\Models\Link')
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
    <div class="card">
        <div class="card-content">
            <span class="card-title">Friend links</span>
            <label>click to edit</label>
            <a href="javascript:void(0)" class="btn btn-floating btn-warning waves-effect right" id="add-btn">
                <i class="material-icons">add</i>
            </a>
            <div class="row">
                <div class="collection">
                    @foreach($friends->all() as $friend)
                        <a href="javascript:void(0)" class="collection-item">
                            <div class="friend-link">
                                <span class="title">{!! $friend->name !!}</span>
                                <p>{!! $friend->link !!}</p>
                            </div>
                            {!! Form::open(['method' => 'post', 'url' => 'settings/friend', 'style' => 'display: none;', 'class' => 'link-form']) !!}
                            {!! Form::hidden('id', $friend->id) !!}
                            {!! Form::text('name', $friend->name) !!}
                            {!! Form::text('link', $friend->link) !!}
                            {!! Form::button('update', ['type' => 'submit', 'class' => 'btn waves-effect btn-success']) !!}
                            {!! Form::close() !!}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal" id="modal">
            <div class="modal-content">
                <h4>New friend link</h4>
            {!! Form::open(['method' => 'post', 'url' => 'settings/friend']) !!}
{{--            {!! Form::text('name', '', ['id' => 'name']) !!}--}}
                {{--<label for="name">name</label>--}}
                {!! formText('s12', 'name', 'friend-name', $errors, 'name', 'face', false) !!}
{{--            {!! Form::text('link', '', ['id' => 'link', 'placeholder' => "no need of 'http://'"]) !!}--}}
                {{--label--}}
                {!! formText('s12', 'link', 'link', $errors, 'link(no need of "http://")', 'web', false) !!}
            {!! Form::button('save', ['type' => 'submit', 'class' => 'btn waves-effect btn-success']) !!}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
