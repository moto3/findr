import '../css/style.scss'

import Vue from 'vue'
import store from './vuex/store'
import App from './vue/app.vue'

import SimpleVueValidation from 'simple-vue-validator'
Vue.use(SimpleVueValidation)

new Vue({
  store,
  el: '#main',
  components: { App }
});
