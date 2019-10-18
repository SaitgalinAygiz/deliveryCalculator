<template>

    <div v-show="hideResults" class="uk-flex@s uk-flex-center uk-margin-large-top uk-background-default uk-padding-large  uk-table-middle">
        <div uk-spinner="ratio: 2" style="display: none"></div>
        <h2 class="uk-margin-medium-bottom" style="text-align: center; ">{{ this.cityFrom }} > {{ this.cityTo }}</h2>

        <table class="uk-table uk-table-divider uk-table-large uk-table-hover ">
            <thead>
            <tr>
                <th class="uk-width-1-3"></th>
                <th class="uk-width-1-4">Компания</th>
                <th class="uk-width-1-4">Срок</th>
                <th class="uk-width-1-4"> Стоимость</th>
            </tr>
            </thead>

            <tbody>

            <tr v-for="result in results" >
                <td>
                    <img id="company-image" :data-src="result.logo"  style="object-fit: cover; width: 150px; height: 50px;" alt="" uk-img>
                </td>
                <td>{{ result.company }}</td>
                <td>{{ result.interval }}</td>
                <td>{{ result.price }} руб.</td>
            </tr>

            </tbody>
        </table>

    </div>

</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Results",



        data() {
            return {
                cityFrom: '',
                cityTo: '',
                hasResults: false
            }

        },

        mounted() {
            this.$store.dispatch('fetchResult');
            this.$bus.$on('sendCities', (result) => {
                this.cityFrom = result.cityFrom;
                this.cityTo = result.cityTo;

            });

        },



        computed: {
            ...mapGetters([
                'results'
            ]),

            hideResults() {

                return this.results.length > 0;

            },





        }
    }

</script>

<style scoped>

</style>
