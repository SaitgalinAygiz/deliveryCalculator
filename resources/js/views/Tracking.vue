<template>



    <div class="uk-background-default uk-padding-large ">

        <div id="calc-heading" class="uk-heading-small ">
            Отслеживание (Временно недоступно)
        </div>


        <input-tracking>

        </input-tracking>


    </div>


</template>

<script>
    export default {
        name: "Tracking",

        beforeCreate() {
            document.getElementById("tracking-link").classList.remove('uk-card-default');
            document.getElementById("tracking-link").classList.add('uk-card-primary');
            document.getElementById("api-link").classList.remove('uk-card-primary');
            document.getElementById("api-link").classList.add('uk-card-default');

            document.getElementById("span-api-link").classList.remove('uk-link-reset');
            document.getElementById("span-api-link").classList.add('uk-link-heading');
            document.getElementById("span-tracking-link").classList.remove('uk-link-heading');
            document.getElementById("span-tracking-link").classList.add('uk-link-reset');



        }
    }




</script>

<style scoped>

</style>
