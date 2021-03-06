/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue').default;

window.axios = require('axios');

import { library } from '@fortawesome/fontawesome-svg-core'

import { faChevronDown, faChevronUp } from '@fortawesome/free-solid-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faChevronDown, faChevronUp);

Vue.use(require('vue-the-mask'));
Vue.use(require('v-money'), { masked: false });
Vue.use(require('maska'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home', require('./components/Home.vue').default);
Vue.component('list-order', require('./components/orders/List.vue').default);
Vue.component('add-order', require('./components/orders/Add.vue').default);
Vue.component('order-list-item', require('./components/orders/OrderListItem.vue').default);

Vue.component('font-awesome-icon', FontAwesomeIcon);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
