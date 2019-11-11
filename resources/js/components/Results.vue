<template>
<div>
    <div class="uk-margin-small-top" v-show="viewLoader" uk-spinner="ratio: 1" ></div>

    <div v-show="hideResults" class="uk-flex@s uk-flex-center uk-padding-large  uk-background-default uk-padding-remove-top  uk-table-middle">

        <div style="display: none" id="bottomScroll" >bottom</div>

        <h2 class="uk-margin-medium-bottom" style="text-align: center; ">{{ this.cityFrom }} > {{ this.cityTo }}</h2>

        <table class="uk-table uk-table-large uk-table-divider  uk-table-hover ">
            <thead>
            <tr>
                <th class="uk-width-1-3"></th>
                <th class="uk-width-1-4">Компания</th>
                <th class="uk-width-1-4">Срок</th>
                <th class="uk-width-1-4">Стоимость</th>
            </tr>
            </thead>

            <tbody>

            <tr v-for="result in results" >
                <td>
                    <img id="company-image" :data-src="result.logo" width="250" height="50"  alt="" uk-img>
                </td>
                <td>{{ result.company }}</td>
                <td>{{ result.interval }}</td>
                <td>{{ result.price }} руб.</td>

            </tr>

            </tbody>
        </table>

        <delivery-points-map>

        </delivery-points-map>

    </div>
</div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import UIkit from 'uikit'

    export default {
        name: "Results",

        data() {
            return {
                cityFrom: '',
                cityTo: '',
                hasResults: false,
                viewLoader: false
            }

        },

        mounted() {



            this.$store.dispatch('fetchResult');
            this.$store.dispatch('fetchCoords');

            this.$bus.$on('sendCities', (result) => {
                this.viewLoader = true;
                this.cityFrom = result.cityFrom;
                this.cityTo = result.cityTo;

            });

        },

        updated() {


            if (this.hideResults === true) {
                document.getElementById('bottomLink').click();

                var images = document.querySelectorAll("td > img");
                var ratio = 250/50, imageHeight;

                setHeight();

                window.onresize = function () {
                    setHeight();
                };

                function setHeight() {
                    imageHeight = images[0].clientWidth / ratio;
                    for (var i = 0; i < images.length; i++) {
                        images[i].style.height = imageHeight + "px";
                    }
                }

            }

        },

        computed: {
            ...mapGetters([
                'results',
                'coords'
            ]),

            hideResults() {

                this.viewLoader = false;

                return this.results.length > 0;

            },

        }
    }

</script>

<style scoped>



</style>
