<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ Setting::get('author') }}">
    <meta name="description" content="{{ Setting::get('desc') }}">
    <meta name="keywords" content="{{ Setting::get('keywords') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}">
</head>
<body>
<header>
    <navigation></navigation>
</header>
<main id="app">
    <div class="container">
        <router-view></router-view>
    </div>
</main>
<footer class="page-footer transparent">
    <div class="footer-copyright">
        <div class="container black-text text-lighten-5">
            Copyright © 2015-2016 forehalo
            <span class="right black-text text-lighten-5" to="/">{{ Setting::get('title') }}</span>
        </div>
    </div>
</footer>
<script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'config' => Setting::all(),
            'currentViewType' => Request::segment(1) ?: 'default',
            'isProduction' => env('APP_ENV') === 'prod' || env('APP_ENV') === 'production'
    ]) !!};
    window.dictionary = {!! json_encode(trans('app')) !!};
</script>
<script src="{{ asset(elixir('js/app.js')) }}"></script>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker
                .register('/js/service-worker.js')
                .then(function(reg) {
                    reg.onupdatefound = function() {
                        var installingWorker = reg.installing;

                        installingWorker.onstatechange = function() {
                            switch (installingWorker.state) {
                                case 'installed':
                                    if (navigator.serviceWorker.controller) {
                                        console.log('New or updated content is available.');
                                    } else {
                                        console.log('Content is now available offline!');
                                    }
                                    break;

                                case 'redundant':
                                    console.error('The installing service worker became redundant.');
                                    break;
                            }
                        };
                    };
                }).catch(function(e) {
                    console.error('Error during service worker registration:', e);
                });
        });
    }
</script>
</body>
</html>
