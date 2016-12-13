<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset(elixir('css/admin.css')) }}">
    <title>{{ config('blog.title') }}</title>
</head>
<body>
<header>
    <navigation></navigation>
</header>
<main>
    <router-view></router-view>
</main>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'config' => config('blog'),
    ]);?>
</script>
<script src="{{ asset(elixir('js/admin.js')) }}"></script>
</body>
</html>
