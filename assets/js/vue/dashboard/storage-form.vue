<template>
  <transition name="slideRight">
    <div id="item-storage" class="pure-g" v-if="showStorageForm">
        <div class="box">
          <form id="storage-form" v-on:submit.prevent="storage_submit(formToString('storage-form'))">
              
            <div class="pure-u-5-5">
              <div class="btn-sm check align-right" v-on:click="close_storage_form"></div>
            </div>

            <div class="pure-u-5-5">
              <label for="name">Storage Spaces</label>
              <ul id="storage-spaces">
                <li class="storage-space" v-for="storage in storageSpacesAll" v-bind:storage="storage" v-bind:key="storage.storage_id" @click="set_active_storage(storage)" :class="{active: storage === activeStorage}" >
                    <strong>{{storage.storage_prefix}}{{storage.storage_number}}: {{storage.storage_name}}</strong>
                    {{storage.storage_description}}
                </li>
              </ul>
                
              <div class="btn-sm plus align-right" v-on:click="add_new_storage"></div>
              <div class="btn-sm minus align-right" :class="{inactive: !activeStorageSelected}"></div>
                
            </div>

              <div class="pure-u-5-5">
                <label>Storage Identifier</label>
              </div>

              <div class="pure-u-1-5">
                <select id="prefix" name="prefix" v-model="storagePrefix">
                  <option v-for="alphabet in alphabets" :value="alphabet.value">
                    {{ alphabet.letter }}
                  </option>
                </select>
              </div>

              <div class="pure-u-4-5">
                <select id="number" name="number" v-model="storageNumber">
                  <option v-for="number in numbers" :value="number.value">
                    {{ number.digit }}
                  </option>
                </select>
              </div>
              
              <div class="pure-u-5-5">
                <label for="name">Storage Name</label>
                <input type="hidden" name="storage_id" :value="storageId">
                <input type="text" id="storage_name" name="storage_name" :value="storageName" />

                <label for="description">Storage Description</label>
                <textarea id="description" name="description" v-model="storageDescription">{{storageDescription}}</textarea>
              </div>
              
              <div class="pure-u-5-5">
                <input type="submit" value="SAVE" />
              </div>

          </form>
        </div> 
    </div>
  </transition>
</template>

<script>
import formToString from '../../vue-mixins/functions';
import {numbers, alphabets} from '../../vue-constants/constants';
import {mapState, mapActions} from 'vuex';

export default {
  mixins: [ formToString ],
  data: function(){
    return {
      alphabets: alphabets(),
      numbers: numbers()
    }
  },
  computed: mapState({
    showStorageForm: state => state.form.storageFormShown,
    storageSpacesAll: state => state.storageSpaces.all,

    storageId: state => state.storageSpaces.active.storage_id,
    storagePrefix: state => state.storageSpaces.active.storage_prefix,
    storageNumber: state => state.storageSpaces.active.storage_number,
    storageName: state => state.storageSpaces.active.storage_name,
    storageDescription: state => state.storageSpaces.active.storage_description,

    activeStorage: state => state.storageSpaces.active,
    activeStorageSelected: state => !(state.storageSpaces.active.storage_id === 0),
    
  }),
  methods: 
    mapActions([
      'set_active_storage',
      'add_new_storage',
      'storage_submit',
      'close_storage_form'
    ]),
  created: function(){
    this.add_new_storage()
  }
}
</script>