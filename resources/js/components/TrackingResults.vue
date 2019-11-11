<template>

    <div>

        <div v-show="viewLoader" uk-spinner="ratio: 1" ></div>

        <div v-show="hideResults" >
        <div class="uk-section uk-section-secondary uk-margin-medium-top">
            <div class="uk-container">

                <h3>Кому: {{ trackingResults.recepient }}</h3>

                <div class="uk-grid-match uk-child-width-1-3@m" uk-grid>
                    <div>
                        <p>Куда: {{ trackingResults.whereToCity }}, {{ trackingResults.whereToIndex }}</p>
                    </div>
                    <div>
                        <p>Масса посылки: {{ trackingResults.weight }} </p>
                    </div>
                    <div>
                        <p>От кого: {{ trackingResults.sender }}</p>
                    </div>
                </div>

            </div>


        </div>

    <table class="uk-table uk-table-large uk-table-divider  uk-padding-large  uk-padding-remove-top uk-table-hover ">
        <thead>
        <tr>
            <th class="uk-width-1-6">Дата</th>
            <th class="uk-width-1-6">Адрес</th>
            <th class="uk-width-1-6">Индекс</th>
            <th class="uk-width-1-3">Название</th>
        </tr>
        </thead>

        <tbody>

        <tr v-for="movement in trackingResults.movements" >
            <td>{{ movement.operationDate }}</td>
            <td>{{ movement.operationAddress }}</td>
            <td>{{ movement.operationIndex }}</td>
            <td>{{ movement.operationName }} </td>

        </tr>

        </tbody>
    </table>
    </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "TrackingResults",

        data() {

            return {
                viewLoader: false,
            }

        },

        mounted() {
            this.$store.dispatch('fetchTrackingResult');

            this.$bus.$on('sendTrackingInput', () => {
                this.viewLoader = true;
            });

        },

        computed: {
            ...mapGetters([
                'trackingResults'
            ]),

            hideResults() {

                this.viewLoader = false;

                return this.trackingResults.sender !== undefined;
            }
        }
    }
</script>

<style scoped>

</style>
