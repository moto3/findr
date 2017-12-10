import '../css/style.scss';

import Vue from 'vue';
import store from './vuex/store';
import App from './vue/app.vue';

new Vue({
  store,
  el: '#main',
  components: { App }
});
