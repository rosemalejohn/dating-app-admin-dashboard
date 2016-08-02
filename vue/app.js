import Vue from 'vue'
import VueResource from 'vue-resource'
import VueValidator from 'vue-validator'

import Config from './config'

Vue.use(VueResource);
Vue.use(VueValidator);

Vue.http.options.root = '/api';
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content')

import App from './App.vue'

window.socket = io(Config.host + ':' + Config.port);

new Vue(App).$mount('body');