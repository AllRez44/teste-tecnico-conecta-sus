import '@babel/polyfill'
import 'mutationobserver-shim'
import Vue from 'vue'
import './plugins/bootstrap-vue'
import './plugins/vue-axios'
import App from './App.vue'
import router from './router'
import store from './store'
import {ValidationProvider, ValidationObserver, extend} from 'vee-validate';
import {required} from "vee-validate/dist/rules";
import VueMask from 'v-mask';

Vue.config.productionTip = false

Vue.use(VueMask);

extend('required', {
  ...required,
  message: 'Obrigatório',
});

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
