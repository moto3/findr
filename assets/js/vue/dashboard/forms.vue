<template>
  <div id="vue-modal" v-cloak>
    <transition name="fade" v-on:after-enter="show_item_form">
	    <div id="modal" class="modal" v-if="showForm" v-on:click.self="close_form">
        <item-form></item-form>
        <storage-list></storage-list>
        <storage-form></storage-form>
      </div>
    </transition>
  </div>
</template>

<script>
import {numbers, alphabets} from '../../vue-constants/constants';
import {mapState, mapActions} from 'vuex';
import ItemForm from './item-form.vue';
import StorageList from './storage-list.vue';
import StorageForm from './storage-form.vue';

export default {
	computed: mapState({
		showForm: state => state.form.shown,
	}),
	data: function(){
		return {
			alphabets: alphabets(),
			numbers: numbers()
		}
	},
	methods: 
		mapActions([
			'show_item_form',
      'close_form'
		]),
  components: {
    ItemForm,
    StorageList,
    StorageForm
  }
}
</script>