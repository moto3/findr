import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'

import items from './modules/items'
import storageSpaces from './modules/storageSpaces'

Vue.use(Vuex)

const state = {
  locale: 'ja',
  loggedInChecked: false,
  loggedIn: false,
  prompt: {
    message:'',
    isError:false
  },
  form: {
    shown: false,
    itemFormShown: false,
    storageListShown: false,
    storageFormShown: false,
    form_mode: 'none'
  },
  isSearching: false
}

const mutations = {
  //LOGIN
  SET_LOGIN_STATUS (state, status) {
    state.loggedInChecked = true;
    state.loggedIn = status;
  },
  //PROMPT
  SET_MESSAGE (state, message) {
    state.prompt.message = message;
    state.prompt.isError = false;
  },
  SET_ERROR (state, message) {
    state.prompt.message = message;
    state.prompt.isError = true;
  },

  //FORMS
  SET_FORM_SHOWN (state, isShown) {
    state.form.shown = isShown;
  },
  SET_FORM_MODE (state, mode) {
    state.form.form_mode = mode;
  },
  SET_ITEM_FORM_SHOWN (state, isShown) {
    state.form.itemFormShown = isShown;
  },
  SET_STORAGE_LIST_SHOWN (state, isShown) {
    state.form.storageListShown = isShown;
  },
  SET_STORAGE_FORM_SHOWN (state, isShown) {
    state.form.storageFormShown = isShown;
  },

  //FIND
  SET_SEARCHING (state, arg_isSearching) {
    state.isSearching = arg_isSearching;
  }

}

export default new Vuex.Store({
  getters,
  state,
  mutations,
  actions,
  modules: {
    items,
    storageSpaces
  },
})

