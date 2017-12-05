<template>
<div id="items" class="box">
  <transition-group name="listmove">
    <item v-for="item in items" v-bind:item="item" v-bind:key="item.item_id"></item>
  </transition-group>
</div>
</template>

<script>
import Item from './item.vue';
import {mapGetters} from 'vuex';
export default {
  computed: mapGetters({
    items: 'get_items'
  }),
  components: {
    Item
  }
}
</script>