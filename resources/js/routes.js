import VueRouter from 'vue-router'


let routes = [
    {

        path: '/',
        component: require('./views/Calculator.vue').default,
        name: 'calculator'

    },
    {
        path: '/tracking',
        component: require('./views/Tracking.vue').default,
        name: 'tracking'
    }
];


export default new VueRouter({
    routes

});
