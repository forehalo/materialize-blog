<div class="divider"></div>
<h5>Make a Comment</h5>

{!! Form::open(['url' => url('comments'), 'class' => 'col s12', 'id' => 'comment-form']) !!}
{!! Form::hidden('post_id', $id) !!}
{!! Form::hidden('parent', 0) !!}
<div class="input-field col s12 l4">
    {!! Form::text('name', old('name'), ['id' => 'name', 'class' => $errors->comment->first('name') ? 'validate invalid' : 'validate' ]) !!}
    <label for="name"><i class="material-icons">perm_identity</i> Name</label>
</div>
<div class="input-field col s12 l4">
    {!! Form::email('email', old('email'), ['id' => 'email', 'class' => $errors->comment->first('email') ? 'validate invalid' : 'validate' ]) !!}
    <label for="email"><i class="material-icons">email</i> Email(invisible)</label>
</div>
<div class="input-field col s12 l4">
    {!! Form::url('blog', old('blog'), ['id' => 'blog', 'class' => $errors->comment->first('blog') ? 'validate invalid' : 'validate' ]) !!}
    <label for="blog"><i class="material-icons">web</i> Website(http://...)</label>
</div>
<div class="input-field col s12">
    {!! Form::textarea('content', old('content'), ['id' => 'content', 'class' => 'materialize-textarea']) !!}
    <label for="content"><i class="material-icons">comment</i>content</label>
</div>
<div class="input-field col s12">
    <button class="btn waves-effect blue" type="submit">submit <i class="material-icons right">send</i></button>
</div>
{!! Form::close() !!}
