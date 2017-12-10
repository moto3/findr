<template>
  <div id="dashboard" v-if="loggedIn">
    <div id="no-result" class="splash-container" v-if="!hasItems">
      <div class="splash">
        &mdash; No Results &mdash;
      </div>
    </div>
    <div id="search-result" v-if="hasItems">
      <items></items>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex';
import Items from './dashboard/items.vue';

export default {
  computed: mapState({
    loggedIn: state => state.loggedIn,
    hasItems: state => state.items.all.length
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