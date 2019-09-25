/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuelidate from 'vuelidate';

Vue.use(Vuelidate);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('navegacao', require('./components/layout/Navegacao.vue').default);
Vue.component('pagina', require('./components/layout/Pagina.vue').default);
Vue.component('painel', require('./components/layout/Painel.vue').default);

Vue.component('tabela', require('./components/Tabela.vue').default);
Vue.component('mensagem', require('./components/Mensagem.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('links-inicio', require('./components/LinksInicio.vue').default);
Vue.component('acoes', require('./components/Acoes.vue').default);
Vue.component('grafico', require('./components/Grafico.vue').default);

Vue.component('pagination', require('laravel-vue-pagination'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './routes';

Vue.filter('moeda', function (value) {
    var numero = parseFloat(value);
    return numero.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
});

Vue.filter('toString', function (value) {
    var codigo = value.toString();
    return codigo;
});

const app = new Vue({
    el: '#app',
    router
});
