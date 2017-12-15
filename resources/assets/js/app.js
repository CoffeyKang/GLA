import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
// elements-ui
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

/**
 * import vue-router
 */
Vue.use(VueRouter);
Vue.use(ElementUI);

import { routes } from './router.js';

const router = new VueRouter({
	routes,

});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
