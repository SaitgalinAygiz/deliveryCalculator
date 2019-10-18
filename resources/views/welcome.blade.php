@extends('layouts.app')

@section('content')



    <div class="uk-container uk-flex@s uk-flex-center uk-margin-medium-top uk-background-default uk-padding-large uk- ">
        <div class="uk-heading-small ">
            Рассчитать стоимость доставки груза через API транспортных компаний
        </div>

        <div class="uk-text-top">Быстрый и точный калькулятор расчета доставки через API (application programming interface)
            самых популярных в России транспортных компаний: СДЭК, Почта России, ПЭК, Деловые Линии, Энергия, Байкал Сервис,
            Желдорэкспедиция, EMS, Главдоставка, GTD, Возовоз, Magic-Trans, Dimex. Расчет стоимости и сроков доставки выполняет
            перевозчик, поэтому данные всегда актуальные.
            Результат выводиться на экран менее, чем за 3 секунды.
        </div>



        <input-calc>

        </input-calc>



        <results>

        </results>

    </div>







@endsection
