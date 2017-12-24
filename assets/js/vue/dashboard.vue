<template>
  <div id="dashboard" v-if="loggedIn">
    <div id="no-result" class="splash-container" v-if="!hasItems">
      <div class="splash">&mdash; {{this.translate('dashboard.no_results')}} &mdash;</div>
    </div>
    <div id="search-result" v-if="hasItems">
      <items></items>
    </div>
  </div>
</template>

<script>
import translations from '../vue-translations/translations'
import i18n from 'vue-i18n-mixin'
import {mapState} from 'vuex';
import Items from './dashboard/items.vue';

export default {
  mixins: [ i18n, translations ],
  computed: mapState({
    loggedIn: state => state.loggedIn,
    hasItems: state => state.items.all.length,
    locale: state => state.locale  
  }),
  components :{
    Items
  },
  updated() {
    if(this.$store.state.loggedIn && !this.loaded){
      console.log('Dashboard Started. Loading items...');
      this.loaded = true;
      this.$store.dispatch('load_items');
      this.$store.dispatch('load_storage');
    }
  }
}
</script>