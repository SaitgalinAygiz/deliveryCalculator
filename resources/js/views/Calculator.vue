<template>




    <div class="uk-background-default uk-padding-large ">

        <div id="calc-heading" class="uk-heading-small ">
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




</template>

<script>
    export default {
        name: "Calculator",

        beforeCreate() {
            document.getElementById("api-link").classList.remove('uk-card-default');
            document.getElementById("api-link").classList.add('uk-card-primary');
            document.getElementById("tracking-link").classList.remove('uk-card-primary');
            document.getElementById("tracking-link").classList.add('uk-card-default');

            document.getElementById("span-tracking-link").classList.remove('uk-link-reset');
            document.getElementById("span-tracking-link").classList.add('uk-link-heading');
            document.getElementById("span-api-link").classList.remove('uk-link-heading');
            document.getElementById("span-api-link").classList.add('uk-link-reset');

        }
    }
</script>

<style scoped>

</style>
