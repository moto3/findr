<template>
  <transition name="slideRight">
    <div id="item-storage" class="pure-g" v-if="showStorageForm">
        <div class="box">
          <form id="storage-form" v-on:submit.prevent="form_validate">

              <div class="pure-u-5-5">
                <div class="btn back align-right" v-on:click="close_storage_form" v-if="!storageEmpty"></div>
                <div class="btn x align-right" v-on:click="close_form" v-if="storageEmpty"></div>
              </div>

              <div class="pure-u-5-5">
                <label>{{this.translate('storage.storage_identifier')}}</label>
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
                <label for="name">{{this.translate('storage.storage_name')}}</label>
                <input type="hidden" name="storage_id" :value="storageId">
                <input type="text" id="storage_name" name="storage_name" v-model="storageName" :class="{error: validation.hasError('storageName')}" />
                <div class="message">{{ validation.firstError('storageName') }}</div>

                <label for="description">{{this.translate('storage.storage_description')}}</label>
                <textarea id="description" name="description" :value="storageDescription">{{storageDescription}}</textarea>
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
import {mapState, mapActions} from 'vuex';

import SimpleVueValidation from 'simple-vue-validator';
var Validator = SimpleVueValidation.Validator;

export default {
  mixins: [ formToString, i18n, translations ],
  data: function(){
    return {
      alphabets: alphabets(),
      numbers: numbers()
    }
  },
  computed: {
    ...mapState({
      locale: state => state.locale,
      showStorageForm: state => state.form.storageFormShown,

      storageId: state => state.storageSpaces.active.storage_id,
      
      storageDescription: state => state.storageSpaces.active.storage_description,

      storageEmpty: state => state.storageSpaces.all.length === 0,

      activeStorage: state => state.storageSpaces.active,
      activeStorageSelected: state => !(state.storageSpaces.active.storage_id === 0)
    }),
    storagePrefix: {
      get() {
        return this.$store.state.storageSpaces.active.storage_prefix
      },
      set(value) {
        this.$store.commit('UPDATE_ACTIVE_STORAGE_PREFIX', value)
      }
    },
    storageNumber: {
      get() {
        return this.$store.state.storageSpaces.active.storage_number
      },
      set(value) {
        this.$store.commit('UPDATE_ACTIVE_STORAGE_NUMBER', value)
      }
    },    
    storageName: {
      get() {
        return this.$store.state.storageSpaces.active.storage_name
      },
      set(value) {
        this.$store.commit('UPDATE_ACTIVE_STORAGE_NAME', value)
      }
    },
  },
  validators: {
    storageName: function(value) {
      return Validator.value(value).required();
    }
  },
  methods: {
    ...mapActions([
      'save_storage',
      'close_storage_form',
      'close_form'
    ]),
    form_validate: function(){
      var parent = this;
      this.$validate()
        .then(function (success) {
          if (success) {
            parent.save_storage(parent.formToString('storage-form'));
          }
        });
    }
  }
}
</script>