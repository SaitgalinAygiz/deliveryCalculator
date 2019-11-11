<template>

    <form method="POST" action="javascript:void(0);" @submit="createTrackingResult(tracking)">


        <fieldset class=" uk-fieldset uk-margin-large-top">

            <div class="uk-flex">
                <div class=" uk-margin-right">
                    <label class="uk-form-label  " for="form-stacked-text"></label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-large" id="form-stacked-text" v-model="tracking.trackingNumber"  type="text" placeholder="Номер отслеживания">
                        <button  :disabled="!isValid" @click.prevent="createTrackingResult(tracking)"  class="uk-button uk-margin-small-left uk-button-danger" >Отследить посылку</button>

                    </div>
                </div>

            </div>


        </fieldset>

    </form>

</template>

<script>
    export default {
        name: "InputTracking",

        data() {
            return {
                tracking: {
                    trackingNumber: 'LO215796144CN',
                }
            }
        },

        computed: {
            isValid() {
                return true;
            }
        },

        methods: {
            createTrackingResult(tracking) {
                this.$store.dispatch('createTrackingResult', tracking);

                this.$bus.$emit('sendTrackingInput', {

                });

            }
        }
    }
</script>

<style scoped>
    .uk-form-width-large {
        width: 800px;
    }

</style>
