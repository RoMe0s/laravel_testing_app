import Vue from 'vue';

import {BootstrapVue} from 'bootstrap-vue';
Vue.use(BootstrapVue);

import DatePicker from 'vue-bootstrap-datetimepicker';
Vue.use(DatePicker);

import AppComponent from '@components/AppComponent';

Vue.component('app-component', AppComponent);

import {Store} from '@store/store';

const app = new Vue({
    store: Store,
    el: '#app',
});
