<div class="divider"></div>
<h5>Make a Comment</h5>
{!! Form::open(['url' => url('/posts/' . $id . '/'), 'class' => 'col s12', 'id' => 'comment-form']) !!}
{!! Form::hidden('parent', 0) !!}
<div class="input-field col s6 l4">
    <input id="name" type="text" class="validate">
    <label for="name"><i class="material-icons">perm_identity</i> Name *</label>
</div>
<div class="input-field col s6 l4">
    <input id="email" type="text" class="validate">
    <label for="email"><i class="material-icons">email</i> Email(hide)</label>
</div>
<div class="input-field col s6 l4">
    <input id="blog" type="text" class="validate">
    <label for="blog"><i class="material-icons">web</i> Website</label>
</div>
<div class="input-field col s12">
    <textarea id="content" class="materialize-textarea"></textarea>
    <label for="content"><i class="material-icons">comment</i>content</label>
</div>
<div class="input-field col s12">
    <button class="btn waves-effect blue" type="submit">submit <i class="material-icons right">send</i></button>
</div>
{!! Form::close() !!}