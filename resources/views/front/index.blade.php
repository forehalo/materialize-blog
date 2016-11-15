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
    </div>
</main>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'config' => config('blog'),
            'currentViewType' => Request::segment(1),
    ]);?>
</script>
<script src="{{ asset(elixir('js/app.js')) }}"></script>
</body>
</html>
