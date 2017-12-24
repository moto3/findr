<template>
  <transition v-bind:name="itemFormTransition">
    <div id="item-add" class="pure-g" v-if="showItemForm">
      <div class="box">
        <div class="pure-u-5-5">
          <div class="btn x align-right" v-on:click="close_form"></div>
        </div>
        <div class="pure-u-5-5">
          <form id="upload-form">
            <label class="btn-photo" id="lbl-fileupload" for="fileupload">{{this.translate('item.upload_photos')}}</label>
            <input id="fileupload" type="file" name="files" @change="upload_image" style="display:none;" />
          </form>
        </div>
        <form id="itemForm" @submit.prevent="form_validate">
          <div class="pure-u-5-5">
            <photo-preview v-for="photo in photoPreviews" v-bind:photodata="photo" v-bind:key="photo.photo_id"></photo-preview>
            <input type="hidden" name="uploaded_files" :value="uploadedFiles" />
          </div>
          <div class="pure-u-5-5">
            <label>{{this.translate('item.storage')}} <div v-on:click="show_storage_list" class="btn sm cog"></div></label>
          </div>
          <div class="pure-u-5-5">
            <select id="storage_id" name="storage_id" v-model="storage_id">
              <option v-for="storage in storageSpacesAll" v-bind:value="storage.storage_id" v-bind:key="storage.storage_id">
                {{ storage.storage_prefix + storage.storage_number + ": " + storage.storage_name }} 
              </option>
            </select>
          </div>
          <div class="pure-u-5-5">
            <label for="name">{{this.translate('item.name')}}</label>
            <input type="hidden" id="item_id" name="item_id" v-bind:value="itemId" />
              <input type="text" id="name" name="name" v-model="itemName" :class="{error: validation.hasError('itemName')}" />
              <div class="message">{{ validation.firstError('itemName') }}</div>
          </div>
          <div class="pure-u-5-5">
            <label for="description">{{this.translate('item.description')}}</label>
            <textarea id="description" name="description" v-model="itemDescription">{{itemDescription}}</textarea>
          </div>
          <div class="pure-u-5-5">
            <input type="submit" :value="this.translate('common.save')" />
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<script>
import formToString from '../../vue-mixins/functions';
import translations from '../../vue-translations/translations'
import i18n from 'vue-i18n-mixin'

import {numbers, alphabets} from '../../vue-constants/constants';
import {mapGetters, mapState, mapActions} from 'vuex';
import PhotoPreview from './photo-preview.vue';

import SimpleVueValidation from 'simple-vue-validator';
var Validator = SimpleVueValidation.Validator;

export default {
  mixins: [ formToString, translations, i18n ],
  computed: {
    ...mapState({
      locale: state => state.locale,
      showItemForm: state => state.form.itemFormShown,
      storageSpacesAll: state => state.storageSpaces.all,
      photoPreviews: state => state.items.active.photos,
      itemId: state => state.items.active.item_id,
      itemFormTransition: state => {
        if(state.form.form_mode == 'itemForm'){
          return 'slideUp'
        }else{
          return 'slideLeft'
        }
      },
      uploadedFiles: state => {
        if(state.items.active.photos.length){
          return state.items.active.photos.map(photo => photo.photoId).reduce((accmltr, photoId) => accmltr + ',' + photoId);
        }else{
          return [];
        }
      }
    }),
    ...mapGetters([

    ]),
    storage_id: {
      get(){
        return this.$store.state.items.active.storage_id
      },
      set(value) {
        this.$store.commit('UPDATE_ACTIVE_STORAGE_ID', value)
      }
    },
    itemName: {
      get() {
        return this.$store.state.items.active.item_name
      },
      set(value) {
        this.$store.commit('UPDATE_ACTIVE_ITEM_NAME', value)
      }
    },
    itemDescription: {
      get() {
        return this.$store.state.items.active.item_description
      },
      set(value) {
        this.$store.commit('UPDATE_ACTIVE_ITEM_DESCRIPTION', value)
      }
    }
  },
  validators: {
    itemName: function(value) {
      return Validator.value(value).required();
    }
  },
  methods: {
    ...mapActions([
      'show_storage_list',
      'upload_image',
      'item_form_submit',
      'close_form'
    ]),
    form_validate: function(){
      var parent = this;
      this.$validate()
        .then(function (success) {
          if (success) {
            parent.item_form_submit(parent.formToString('itemForm'));
          }
        });
    }
  },
  components: {
    PhotoPreview
  }
}
</script>