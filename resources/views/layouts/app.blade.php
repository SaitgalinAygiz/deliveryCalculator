<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


    <!-- Styles -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
<div class=" uk-padding-large uk-height-viewport uk-background-secondary  ">




    <main id="app">
        @yield('content')
    </main>
</div>
</body>
</html>
