<template>

        <form method="POST" action="javascript:void(0);" @submit="createResult(result)" >

            <fieldset class=" uk-fieldset uk-margin-medium-top">

                <div class="uk-flex">
                    <div class=" uk-margin-right uk-width-1-2">
                        <label class="uk-form-label  " for="form-stacked-text">Город отправления</label>
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





                <div class="uk-margin-large-top uk-grid-small uk-child-width-1-3@s" uk-grid>
                    <label><input id="nrg-checkbox" class="uk-checkbox" v-model="result.nrgCheckbox" type="checkbox" checked> Энергия</label>
                    <label><input id="pecom-checkbox" class="uk-checkbox" v-model="result.pecomCheckbox" type="checkbox" checked> ПЭК  </label>
                    <label><input id="dellin-checkbox" class="uk-checkbox" v-model="result.dellinCheckbox" type="checkbox"> Деловые Линии (долго отвечает)</label>
                    <label><input id="baikal-checkbox" class="uk-checkbox" v-model="result.baikalCheckbox" type="checkbox" checked> Байкал сервис</label>
                    <label><input id="gtd-checkbox" class="uk-checkbox" v-model="result.gtdCheckbox" type="checkbox" checked> GTD</label>
                    <label><input id="vozovoz-checkbox" class="uk-checkbox" v-model="result.vozovozCheckbox" type="checkbox" checked> Возовоз</label>
                    <label><input id="glavdostavka-checkbox" class="uk-checkbox" v-model="result.glavdostavkaCheckbox" type="checkbox" checked> Главдоставка</label>
                    <label><input id="jde-checkbox" class="uk-checkbox" v-model="result.jdeCheckbox" type="checkbox" checked> ЖелДорЭкспедиция</label>
                    <label><input id="dimex-checkbox" class="uk-checkbox" v-model="result.dimexCheckbox" type="checkbox" checked> Dimex</label>


                </div>


            </fieldset>

            <div class="uk-flex uk-flex-center">
                <button :disabled="!isValid"  @click.prevent="createResult(result)" class="uk-margin-large-top uk-button   uk-button-primary" >Рассчитать стоимость доставки</button>

                <a id="bottomLink" href="#bottomScroll" uk-scroll></a>
            </div>
        </form>


</template>



<script>
    export default {

        data(){
            return {
                result: {
                    cityFrom: 'Москва',
                    cityTo: 'Уфа',
                    weight: '1',
                    width: '100',
                    height: '100',
                    length: '100',
                    nrgCheckbox: false,
                    pecomCheckbox: false,
                    dellinCheckbox: false,
                    baikalCheckbox: false,
                    gtdCheckbox: false,
                    vozovozCheckbox: false,
                    glavdostavkaCheckbox: false,
                    jdeCheckbox: false,
                    dimexCheckbox: false
                }
        }
        },

        methods: {
            createResult(result) {

                this.$store.dispatch('createResult', result);
                this.$bus.$emit('sendCities', {
                    cityFrom: result.cityFrom,
                    cityTo: result.cityTo,

                });


            }

        },

        mounted() {
            console.log('Component mounted.')
        },
        computed: {
            isValid() {

                return this.result.cityFrom !== '' && this.result.cityTo !== ''  && this.result.weight !== ''
                    && this.result.width !== ''  && this.result.height !== ''  && this.result.length !== ''
                && this.result.length > 0 && this.result.height > 0 && this.result.weight > 0
                && this.result.width > 0 && ( this.result.nrgCheckbox || this.result.pecomCheckbox ||
                        this.result.dellinCheckbox || this.result.baikalCheckbox || this.result.gtdCheckbox || this.result.vozovozCheckbox ||
                        this.result.glavdostavkaCheckbox || this.result.jdeCheckbox || this.result.dimexCheckbox)
                && !this.result.width.includes('.') && !this.result.height.includes('.') && !this.result.length.includes('.')
                    && !this.result.weight.includes('.')

            },


        }

    }

</script>
