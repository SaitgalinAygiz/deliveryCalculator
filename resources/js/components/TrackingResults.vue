<template>
    <div v-show="hideResults" >
        <div class="uk-section uk-section-secondary uk-margin-medium-top">
            <div class="uk-container">

                <h3>Кому: {{ trackingResults.recepient }}</h3>

                <div class="uk-grid-match uk-child-width-1-3@m" uk-grid>
                    <div>
                        <p>Куда: {{ trackingResults.whereToCity }}, {{ trackingResults.whereToIndex }}</p>
                    </div>
                    <div>
                        <p>Масса посылки: {{ trackingResults.weight }} г</p>
                    </div>
                    <div>
                        <p>От кого: {{ trackingResults.sender }}</p>
                    </div>
                </div>

            </div>


        </div>

    <table class="uk-table uk-table-large uk-table-divider  uk-table-hover ">
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
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "TrackingResults",

        mounted() {
            this.$store.dispatch('fetchTrackingResult');
        },

        computed: {
            ...mapGetters([
                'trackingResults'
            ]),

            hideResults() {

                return this.trackingResults.sender !== undefined;
            }
        }
    }
</script>

<style scoped>

</style>
