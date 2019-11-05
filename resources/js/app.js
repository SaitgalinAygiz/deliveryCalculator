/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

require('uikit/dist/js/uikit.min');
window.Vue = require('vue');

import store from './store/index';
import YmapPlugin from 'vue-yandex-maps'
import routes from './routes';
import VueRouter from 'vue-router';


const settings = {
    apiKey: '8ebea8f7-96e8-48de-b0b7-83d722db9b86',
    lang: 'ru_RU',
    coordorder: 'latlong',
    version: '2.1'
};

Vue.use(YmapPlugin, settings);
Vue.use(VueRouter);



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('input-calc', require('./components/InputCalc.vue').default);
Vue.component('results', require('./components/Results.vue').default);
Vue.component('delivery-points-map', require('./components/DeliveryPointsMap.vue').default);
Vue.component('input-tracking', require('./components/InputTracking.vue').default);


Object.defineProperty(Vue.prototype, '$bus',{
    get() {
        return this.$root.bus;
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var bus = new Vue({}); // This empty Vue model will serve as our event bus.

new Vue({
    el: '#app',
    data: {
        bus: new Vue({})
    },
    store,
    router: routes,
});
