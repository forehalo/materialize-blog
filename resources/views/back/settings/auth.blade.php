<div id="auth" class="col s12 l8">
    {!! Form::open(['method' => 'post', 'url' => 'settings/auth']) !!}
    <div class="card">
        <div class="card-content">
            <span class="card-title">Auth</span>
            <div class="row">
                {!! formText('s12 l8', 'name', 'login-name', $errors, 'Login name', 'person', true, session('user_name')) !!}
                {!! formText('s12 l8', 'email', 'login-email', $errors, 'Login email', 'email', true, session('user_email'), 'email') !!}
                {!! formText('s12 l8', 'password', 'password', $errors, 'Password', 'lock', true, '', 'password') !!}
                {!! formText('s12 l8', 'password_confirmation', 'confirm-password', $errors, 'Enter password again', 'lock', true, '', 'password') !!}
            </div>
            {!! Form::button('Update', ['type' => 'submit', 'class' => 'btn waves-effect']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>