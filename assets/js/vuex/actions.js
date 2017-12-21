import axios from 'axios'
import translations from '../vue-translations/translations'
import i18n from 'vue-i18n-mixin'

// LOGIN
export const check_login = ({ commit }) => {
  var self = this;
  axios.post('/users/login/check')
    .then(function (response) {
      commit('SET_LOGIN_STATUS', response.data);
    })
    .catch(function (error) {
      console.log(error);
    });
}
export const login = (store, input) => {
  axios.post('/users/login', input)
    .then(function (response) {
      if(response.data){
        var data = {message:'login.success', success: true}
      }else{
        var data = {message:'login.failed', success: false}
      }
      set_prompt(store, data);
      check_login(store);
    })
    .catch(function (error) {
      console.log(error);
    });
}

//PROMPT
export const set_prompt = ({commit}, data) => {
  if(data.success){
    commit('SET_MESSAGE', data.message);
  }else{
    commit('SET_ERROR', data.message);
  }
  setTimeout(function(){
    commit('SET_MESSAGE', '');
  }, 3000);
} 

//FIND
export const find_item = (store, e) => {
  find_item_func(store, e.target.value)
}
export const find_item_evoke = (store) => {
  find_item_func(store, document.getElementById('fld_find').value)
}
export const find_item_func = (store, str_search) => {
  if(str_search.length >= 2){
    var array_search_str = str_search.split(' ')
    array_search_str = array_search_str.filter(str => str.length > 1)
    var filtered_items = store.rootState.items.all.filter(
      item => { 
        var str_storage = item.storage_prefix + item.storage_number
        var match = true
        for(var i = 0; i < array_search_str.length; i++){
          var re = new RegExp(array_search_str[i], 'i')
          if(!item.item_name.match(re) && !item.item_description.match(re) && !str_storage.match(re)){
            match = false
          }
        }
        return match
      }
    )
    store.commit('SET_SEARCHING', true)
    store.commit('SET_FILTERED_ITEMS', filtered_items)
  }else{
    store.commit('SET_SEARCHING', false)
  }
}

//FORM
export const close_form = ({commit}) => {
  commit('SET_FORM_SHOWN', false);
  commit('SET_ITEM_FORM_SHOWN', false);
  commit('SET_STORAGE_LIST_SHOWN', false);
  commit('SET_STORAGE_FORM_SHOWN', false);
  commit('SET_FORM_MODE', 'none');
}
export const open_form = ({commit}) => {
  commit('SET_FORM_SHOWN', true);
}
export const set_form_mode = ({commit}, mode) => {
  commit('SET_FORM_MODE', mode);
}
export const show_item_form = (store) => {
  set_form_mode(store,'itemForm');
  setTimeout(function(){
    store.commit('SET_ITEM_FORM_SHOWN', true);
  })
}
export const show_storage_list = (store) => {
  set_form_mode(store,'storageList');
  setTimeout(function(){
    store.commit('SET_ITEM_FORM_SHOWN', false);
    store.commit('SET_STORAGE_LIST_SHOWN', true);
  })
}
export const close_storage_list = (store) => {
  set_form_mode(store,'storageList');
  setTimeout(function(){
    store.commit('SET_ITEM_FORM_SHOWN', true);
    store.commit('SET_STORAGE_LIST_SHOWN', false);
  })
}
export const show_storage_form = (store) => {
  set_form_mode(store,'storageForm');
  setTimeout(function(){
    store.commit('SET_STORAGE_LIST_SHOWN', false);
    store.commit('SET_STORAGE_FORM_SHOWN', true);
  });
}
export const close_storage_form = ({commit}) => {
  commit('SET_STORAGE_LIST_SHOWN', true);
  commit('SET_STORAGE_FORM_SHOWN', false);
}

