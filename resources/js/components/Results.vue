<template>

    <div class="uk-flex@s uk-flex-center uk-margin-large-top uk-background-default uk-padding-large uk-table-middle">
        <div uk-spinner="ratio: 2" style="display: none"></div>
        <h2 class="uk-margin-medium-bottom" style="text-align: center;">МОСКВА -> САНКТ-ПЕТЕРБУРГ</h2>

        <table class="uk-table uk-table-striped uk-table-large uk-table-hover ">
            <thead>
            <tr>
                <th class="uk-width-1-3"></th>
                <th class="uk-width-1-4">Компания</th>
                <th class="uk-width-1-4">Срок</th>
                <th class="uk-width-1-4"> Стоимость</th>
            </tr>
            </thead>

            <tbody>

            <tr v-for="result in results">
                <td>
                    <img id="company-image" :data-src="result.logo" width="200" height="100" alt="" uk-img>
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
        mounted() {
            this.$store.dispatch('fetchResult');

        },

        computed: {
            ...mapGetters([
                'results'
            ])
        }
    }


    //{{ result.logo }}
</script>

<style scoped>

</style>
