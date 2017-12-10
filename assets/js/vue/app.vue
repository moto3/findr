<template>
  <div id="app">
    <login></login>
    <prompt></prompt>
    <find></find>
    <dashboard></dashboard>
    <forms></forms>
    <bottom-widgets></bottom-widgets>
  </div>
</template>

<script>
import {mapActions} from 'vuex';

import Login from './login.vue';
import Find from './find.vue';
import Prompt from './prompt.vue';
import Dashboard from './dashboard.vue';
import Forms from './dashboard/forms.vue';
import BottomWidgets from './bottom-widgets.vue';

export default {
  name: 'app',
  methods: mapActions([
    'check_login'
  ]),
  created(){
    this.check_login();
  },
  components:{
    Login, Find, Prompt, Dashboard, Forms, BottomWidgets
  }
}
</script>