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
<body  >


<div    class="uk-padding-large  uk-grid uk-height-viewport uk-background-secondary" uk-grid>


        <div class="uk-flex-top uk-grid-item-match uk-width-1-6" style="position: fixed">
            <a id="api-link" href="/#/"  class=" uk-card uk-card-body uk-card-default uk-link-toggle uk-width-medium" >
                 <h3 class="uk-card-title"><span id="span-api-link" class="uk-link-heading">API калькулятор</span></h3>
            </a>
            <a id="tracking-link" href="/#/tracking" class=" uk-card uk-card-body uk-card-default uk-link-toggle uk-width-medium"  >
                <h3 class="uk-card-title"><span id="span-tracking-link" class="uk-link-heading">Отслеживание</span></h3>
            </a>
            <a id="lk-link" href class=" uk-card uk-card-body uk-card-default uk-link-toggle uk-width-medium"  >
                <h3 class="uk-card-title"><span class="uk-link-heading">Личный кабинет</span></h3>
            </a>
        </div>



        <div class="uk-grid-item-match uk-flex-top uk-width-2-3  uk-align-center" style="margin-top: 0px;" >

            <main id="app">

                <router-view></router-view>

               @yield('content')
            </main>
        </div>

</div>

</body>
</html>
