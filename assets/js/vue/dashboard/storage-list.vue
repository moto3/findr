<template>
  <transition v-bind:name="storageListTransition" >
    <div id="item-storage" class="pure-g" v-if="showStorageList">
      <div class="box">
              
          <div class="pure-u-5-5">
            <div class="btn back align-right" v-on:click="close_storage_list"></div>
          </div>

          <div class="pure-u-5-5">
            <label for="name" class="first">Storage Spaces</label>
            <transition-group tag="ul" id="storage-spaces" name="listmove">
              <li class="storage-space" v-for="storage in storageSpacesAll" v-bind:storage="storage" v-bind:key="storage.storage_id" @click="set_active_storage(storage)" :class="{active: storage === activeStorage}" >
                    <strong>{{storage.storage_prefix}}{{storage.storage_number}}: {{storage.storage_name}}</strong>
                    {{storage.storage_description}}
              </li>
            </transition-group>
            <div class="btn sm plus align-right" v-on:click="add_new_storage"></div>
            <div class="btn sm minus align-right" :class="{inactive: !activeStorageSelected}" @click="delete_storage"></div>
            <div class="btn sm pen align-right" :class="{inactive: !activeStorageSelected}" v-on:click="edit_storage"></div>
          </div>

      </div> 
    </div>
  </transition>
</template>

<script>
import formToString from '../../vue-mixins/functions';
import {numbers, alphabets} from '../../vue-constants/constants';
import {mapState, mapActions} from 'vuex';

export default {
  data: function(){
    return {
      alphabets: alphabets(),
      numbers: numbers()
    }
  },
  computed: mapState({
    showStorageList: state => state.form.storageListShown,
    storageSpacesAll: state => state.storageSpaces.all,
    activeStorage: state => state.storageSpaces.active,
    activeStorageSelected: state => state.storageSpaces.active.storage_id,
    storageListTransition: state => {
      if(state.form.form_mode == 'storageForm'){
        return 'slideLeft'
      }else{
        return 'slideRight'
      }
    }

  }),
  methods: 
    mapActions([
      'set_active_storage',
      'add_new_storage',
      'edit_storage',
      'storage_submit',
      'close_storage_list',
      'delete_storage'
    ])
}
</script>