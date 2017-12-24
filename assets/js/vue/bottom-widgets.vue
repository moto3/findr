<template>
  <div id="bottom-widgets" v-if="loggedIn">
	  <div class="btn-add" v-on:click="add_new_item"></div>
  </div>
</template>

<script>
  import {mapState, mapActions} from 'vuex'
  export default {
    computed: mapState({
      loggedIn: state => state.loggedIn
    }),
    methods: mapActions([
      'add_new_item', //this.$store.dispatch('add_new_item')
    ])
  }
</script>