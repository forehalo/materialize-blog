<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('blog.title') }}</title>
    <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}">
</head>
<body>
<header>
    <navigation></navigation>
</header>
<main id="app">
    <div class="container">
        <transition :name="transitionName"
                    :leave-active-class="'animated ' + leaveClass"
                    mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</main>
<footer class="page-footer transparent">
    <div class="footer-copyright">
        <div class="container black-text text-lighten-5">
            Copyright © 2015-2016 forehalo
            <span class="right black-text text-lighten-5" to="/">// Forehalo</router-link>
        </div>
    </div>
</footer>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'config' => config('blog'),
            'currentViewType' => Request::segment(1) ?: 'default',
    ]);?>
</script>
<script src="{{ asset(elixir('js/app.js')) }}"></script>
</body>
</html>
