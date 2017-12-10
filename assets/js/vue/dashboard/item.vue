<template>
  <div class="item pure-g cursor" @click="set_active_item(item)">
    <div class="pure-u-4-24 photo" v-bind:style="{ 'background-image': 'url(' + photo_fileName + ')' }"></div>
    <div class="pure-u-16-24 content"><h2>{{ item.item_name }}</h2><p>{{ item.item_description }}</p></div>
    <div class="pure-u-4-24 label">{{ item.storage_prefix }} {{ item.storage_number }}</div>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
  props: ['item'],
  computed: {
    photo_fileName: function(){
      if(this.item.photos.length){
        return '/uploaded-files/' + this.item.photos[0].fileName
      }else{
        return '/assets/images/icon-photo-sm.png';
      }
    }
  },
  methods: {
    ...mapActions([
      'set_active_item'
    ]),
    testanimation(){
      this.$store.dispatch('remove_one');
    }
  }
}
</script>