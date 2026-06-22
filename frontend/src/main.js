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
import { getOnlyNumbers } from '@/utils';

Vue.config.productionTip = false

Vue.use(VueMask);

extend('required', {
  ...required,
  message: 'Obrigatório',
});

extend('past_or_today', {
  validate(value) {
    if (!value) return true;
    const [year, month, day] = value.split('-');
    const selectedDate = new Date(year, month - 1, day);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return selectedDate <= today;
  },
  message: '{_field_} não pode ser uma data futura'
});

extend('digits', {
  validate(value, { length }) {
    if (!value) return true;
    const cleanValue = getOnlyNumbers(value);
    return cleanValue.length === Number(length);
  },
  params: ['length'],
  message: '{_field_} inválido'
});

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
