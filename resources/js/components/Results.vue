<template>
<div>
    <div v-show="viewLoader" uk-spinner="ratio: 2" ></div>

    <div v-show="hideResults" class="uk-flex@s uk-flex-center  uk-background-default uk-padding-large uk-padding-remove-top  uk-table-middle">

        <div style="display: none" id="bottomScroll" >bottom</div>

        <h2 class="uk-margin-medium-bottom" style="text-align: center; ">{{ this.cityFrom }} > {{ this.cityTo }}</h2>

        <table class="uk-table uk-table-divider uk-table-large uk-table-hover ">
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
                    <img id="company-image" :data-src="result.logo" width="240" height="70"  alt="" uk-img>
                </td>
                <td>{{ result.company }}</td>
                <td>{{ result.interval }}</td>
                <td>{{ result.price }} руб.</td>

            </tr>

            </tbody>
        </table>


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

            this.$bus.$on('sendCities', (result) => {
                this.viewLoader = true;
                this.cityFrom = result.cityFrom;
                this.cityTo = result.cityTo;

            });

        },

        updated() {


            if (this.hideResults === true) {
                document.getElementById('bottomLink').click();
            }

        },



        computed: {
            ...mapGetters([
                'results'
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
