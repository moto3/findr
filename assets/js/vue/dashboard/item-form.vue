<template>
  <transition v-bind:name="itemFormTransition" v-on:after-enter="set_form_mode('item')">
    <div id="item-add" class="pure-g" v-if="showItemForm">
      <div class="box">
        <div class="pure-u-5-5">
          <form id="upload-form">
            <label class="btn btn-photo" id="lbl-fileupload" for="fileupload">Upload photos...</label>
            <input id="fileupload" type="file" name="files" @change="upload_image" style="display:none;" />
          </form>
        </div>
        <form id="item-form" v-on:submit.prevent="item_form_submit(formToString('item-form'))">
          <div class="pure-u-5-5">
            <photo-preview v-for="photo in photoPreviews" v-bind:photodata="photo" v-bind:key="photo.photo_id"></photo-preview>
            <input type="hidden" name="uploaded_files" :value="uploadedFiles" />
          </div>
          <div class="pure-u-5-5">
            <label>Storage <div v-on:click="show_storage_form" class="btn-sm cog"></div></label>
          </div>
          <div class="pure-u-5-5">
            <select id="storage_id" name="storage_id" :value="storage_id">
              <option v-for="storage in storageSpacesAll" v-bind:value="storage.storage_id" v-bind:key="storage.storage_id">
                {{ storage.storage_prefix + storage.storage_number + ": " + storage.storage_name }} 
              </option>
            </select>
          </div>
          <div class="pure-u-5-5">
            <label for="name">Name</label>
            <input type="hidden" id="item_id" name="item_id" v-bind:value="itemId" />
            <input type="text" id="name" name="name" :class="{'error': false }" :value="itemName" />
            <span class="error"></span>
          </div>
          <div class="pure-u-5-5">
            <label for="description">Description</label>
            <textarea id="description" name="description" v-bind:value="itemDescription">{{itemDescription}}</textarea>
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
import {mapGetters, mapState, mapActions} from 'vuex';
import PhotoPreview from './photo-preview.vue';

export default {
  mixins: [ formToString ],
  computed:
    mapState({
      showItemForm: state => state.form.itemFormShown,

      storageSpacesAll: state => state.storageSpaces.all,

      storage_id: state => state.items.active.storage_id,
      photoPreviews: state => state.items.active.photos,
      itemId: state => state.items.active.item_id,
      itemName: state => state.items.active.item_name,
      itemDescription: state => state.items.active.item_description,

      itemFormTransition: state => {
        if(state.form.form_mode == 'none'){
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
  methods: 
    mapActions([
      'set_form_mode',
      'show_storage_form',
      'upload_image',
      'item_form_submit'
    ]),
  components: {
    PhotoPreview
  }
}
</script>