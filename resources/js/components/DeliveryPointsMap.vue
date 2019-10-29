<template>

    <div>

        <h2 class="uk-card-title uk-margin-medium-top">Карта пунктов выдачи</h2>


        <yandex-map
            :coords="[54.734773, 55.957829]"
            :zoom="11"
        >

            <template v-for="result in results">

                <ymap-marker
                    v-for="branch in result.branches"
                    v-bind:key="branch[0]"
                    v-bind:coords="[branch[0], branch[1]]"
                    v-bind:icon="markerIcon(result.company)"
                    markerId="123"
                />
            </template>


        </yandex-map>

    </div>
</template>

<script>
    import {mapGetters} from 'vuex'


    import { yandexMap, ymapMarker } from 'vue-yandex-maps'

    export default {
        components: { yandexMap, ymapMarker },

        name: "DeliveryPointsMap",
        data: () => ({


        }),

        methods: {
            markerIcon(company) {
                return {
                    imageSize: [43, 43],
                    imageOffset: [0, 0],
                    contentOffset: [0, 15],
                    content: company,
                    contentLayout: '<div class="polygon_layout">$[properties.iconContent]</div>'
                }
            }
        },

        mounted() {

            this.$store.dispatch('fetchResult');

        },

        computed: {
            ...mapGetters([
                'results'
            ])
        },


    }
</script>

<style scoped>

    .ymap-container {
        height: 400px;
    }

</style>
