<template>

        <form action="javascript:void(0);" @submit="createResult(result)">
            <fieldset class=" uk-fieldset uk-margin-medium-top">

                <div class="uk-flex">
                    <div class=" uk-margin-right uk-width-1-2">
                        <label class="uk-form-label" for="form-stacked-text">Город отправления</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" v-model="result.cityFrom" type="text" placeholder="Екатеринбург">

                        </div>
                    </div>

                    <div class=" uk-width-1-2">
                        <label class="uk-form-label" for="form-stacked-text">Город получения</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" v-model="result.cityTo" type="text" placeholder="Екатеринбург">
                        </div>
                    </div>
                </div>

                <div class="uk-flex uk-margin-medium-top">
                    <div class=" uk-margin-right uk-width-1-4">
                        <label class="uk-form-label" for="form-stacked-text">Длина, см</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" v-model="result.length" type="number" placeholder="В целых числах">
                        </div>
                    </div>

                    <div class="uk-margin-right uk-width-1-4">
                        <label class="uk-form-label" for="form-stacked-text">Ширина, см</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" v-model="result.width" type="number" placeholder="В целых числах">
                        </div>
                    </div>
                    <div class=" uk-margin-right uk-width-1-4">
                        <label class="uk-form-label" for="form-stacked-text">Высота, см</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" v-model="result.height" type="number" placeholder="В целых числах">
                        </div>
                    </div>

                    <div class=" uk-width-1-4">
                        <label class="uk-form-label" for="form-stacked-text">Вес, кг</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" v-model="result.weight" type="number" placeholder="В целых числах">
                        </div>
                    </div>
                </div>





                <div class="uk-margin-large-top uk-grid-small uk-child-width-auto uk-grid">
                    <label><input class="uk-checkbox" type="checkbox" checked> Энергия</label>
                    <label><input class="uk-checkbox" type="checkbox"> ПЭК</label>
                    <label><input class="uk-checkbox" type="checkbox"> Деловые Линии</label>

                </div>


            </fieldset>

            <div class="uk-flex uk-flex-center">
                <button :disabled="!isValid" @click.prevent="createResult(result)" class="uk-margin-large-top uk-button uk-button-default uk-button-primary">Рассчитать стоимость доставки</button>

            </div>
        </form>


</template>



<script>
    export default {

        data(){
            return {
                result: {
                    cityFrom: 500019972,
                    cityTo: 346,
                    weight: '',
                    width: '',
                    height: '',
                    length: ''
                }
        }
        },

        methods: {
            createResult(result) {
                this.$store.dispatch('createResult', result)
            }

        },

        mounted() {
            console.log('Component mounted.')
        },
        computed: {
            isValid() {
                return this.result.cityFrom !== '' && this.result.cityTo !== ''  && this.result.weight !== ''
                    && this.result.width !== ''  && this.result.height !== ''  && this.result.length !== ''
            }
        }
    }
</script>
