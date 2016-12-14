<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset(elixir('css/dashboard.css')) }}">
    <title>{{ config('blog.title') }}</title>
</head>
<body>
<header>
    <navigation></navigation>
</header>
<main>
    <div class="col s12 m12 l10">
        <circular-loader id="main-preloader" size="tiny" :loading="store.loading" class="right"></circular-loader>
        <router-view></router-view>
    </div>
</main>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'config' => config('blog'),
    ]);?>
</script>
<script src="{{ asset(elixir('js/dashboard.js')) }}"></script>
</body>
</html>
