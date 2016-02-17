<div class="divider"></div>
<h5>Make a Comment</h5>

{!! Form::open(['url' => url('comments'), 'class' => 'col s12', 'id' => 'comment-form']) !!}
{!! Form::hidden('post_id', $id) !!}
{!! Form::hidden('slug', $slug) !!}
{!! Form::hidden('parent', 0) !!}

{!! formText('s12 l4', 'name', 'name' . $id, $errors, 'Name', 'person') !!}
{!! formText('s12 l4', 'email', 'email' . $id, $errors, 'Email(invisible)', 'email') !!}
{!! formText('s12 l4', 'blog', 'blog' . $id, $errors, 'Website(http://...)', 'web') !!}
<div class="input-field col s12">
    {!! Form::textarea('origin', old('origin'), ['id' => 'origin' . $id, 'class' => 'materialize-textarea']) !!}
    <label for="origin{!! $id !!}"><i class="material-icons">comment</i>content (markdown)</label>
</div>
<div class="input-field captcha-field col s12">
    <div class="captcha-input">
        {!! Form::text('captcha', '', ['class' => 'captcha validate', 'id' => 'captcha' . $id]) !!}
        <label for="captcha{!! $id !!}"><i class="material-icons">security</i>captcha</label>
    </div>
    <img src="{!! url('/captcha') !!}" alt="" class="captcha-img"/>
</div>
<div class="input-field col s12 m5 l6">
    <button class="btn waves-effect blue" type="submit">submit <i class="material-icons right">send</i></button>
</div>
<div class="input-field col s12 m7 l6">
    @if($viewButton == true)
        <a href="{!! url('posts/' . $slug . '#comments') !!}" class="btn waves-effect green">View Comments <i
                    class="material-icons right">cloud</i></a>
    @endif
</div>
{!! Form::close() !!}
