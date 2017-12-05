import axios from 'axios'

// LOGIN
export const check_login = ({ commit }) => {
  var self = this;
  axios.post('/users/login/check')
    .then(function (response) {
      //console.log(response);
      commit('SET_LOGIN_STATUS', response.data);
    })
    .catch(function (error) {
      console.log(error);
    });
}
export const login = (store, input) => {
  axios.post('/users/login', input)
    .then(function (response) {
      //console.log(response);
      if(response.data){
        set_prompt(store, 'Login Success', false);
      }else{
        set_prompt(store, 'Login Failed', true);
      }
      check_login(store);
    })
    .catch(function (error) {
      console.log(error);
    });
}

//PROMPT
export const set_prompt = ({commit}, message, isError) => {
  if(isError){
    commit('SET_ERROR', message);
  }else{
    commit('SET_MESSAGE', message);
  }
  setTimeout(function(){
    commit('SET_MESSAGE', '');
  }, 5000);
} 

//FIND
export const find_item = (store, e) => {
  if(e.target.value.length > 2){

    console.log(e.target.value);
    console.log(store.rootState.items.all);
    
    var filtered_items = store.rootState.items.all.filter(item => item.item_name.length > 6);
    console.log(filtered_items);

    store.commit('SET_SEARCHING', true);
    store.commit('SET_FILTERED_ITEMS', filtered_items)
    
  }else{
    store.commit('SET_SEARCHING', false);
  }
}

//FORM
export const close_form = ({commit}) => {
  commit('SET_FORM_SHOWN', false);
  commit('SET_ITEM_FORM_SHOWN', false);
  commit('SET_STORAGE_FORM_SHOWN', false);
  commit('SET_FORM_MODE', 'none'  );
}
export const open_form = ({commit}) => {
  commit('SET_FORM_SHOWN', true);
}
export const set_form_mode = ({commit}, mode) => {
  commit('SET_FORM_MODE', mode);
}
export const show_item_form = ({commit}) => {
  commit('SET_ITEM_FORM_SHOWN', true);
}
export const show_storage_form = ({commit}) => {
  commit('SET_ITEM_FORM_SHOWN', false);
  commit('SET_STORAGE_FORM_SHOWN', true);
}
export const close_storage_form = ({commit}) => {
  commit('SET_ITEM_FORM_SHOWN', true);
  commit('SET_STORAGE_FORM_SHOWN', false);
}

