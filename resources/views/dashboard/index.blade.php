<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset(elixir('css/dashboard.css')) }}">
    <title>{{ Setting::get('title') }}</title>
</head>
<body>
<header>
    <navigation></navigation>
</header>
<main>
    <router-link v-show="showActionButton"
                 to="/dashboard/posts/create"
                 class="fixed-action-btn btn-floating btn-large waves-effect waves-light blue tooltipped hide-on-med-and-down"
                 data-position="left" data-delay="50" :data-tooltip="$trans('create')">
        <i class="material-icons">mode_edit</i>
    </router-link>
    <div class="col s12 m12 l10">
        <circular-loader id="main-preloader" size="tiny" :loading="store.loading" class="right"></circular-loader>
        <router-view></router-view>
    </div>
</main>
<script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'config' => Setting::all(),
    ]) !!};
    window.dictionary = {!! json_encode(trans('app')) !!};
</script>
<script src="{{ asset(elixir('js/dashboard.js')) }}"></script>
</body>
</html>
