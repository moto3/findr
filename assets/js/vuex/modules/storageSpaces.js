import axios from 'axios'

const state = {
  all: [],
  active: {}
}

const actions = {
  load_storage({commit}) {
    const request = axios.post('/storage/load')
    .then(function (response) {
      if(response.data.length > 0){
        commit('LOAD_STORAGE', response.data);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
    return request;
  },
  set_active_storage (store, storage) {
    store.commit('SET_ACTIVE_STORAGE', storage);
  },
  add_new_storage (store, storage) {
    store.commit('ADD_STORAGE');
    store.dispatch('show_storage_form');   
  },
  edit_storage (store) {
    if(store.state.active.storage_id){
      store.dispatch('show_storage_form');
    }
  },
  delete_storage (store) {
    if(store.state.active.storage_id){
      var r = confirm("Are you sure?");
      if (r == true) {
        const input = 'storage_id=' + store.state.active.storage_id;
        axios.post('/storage/delete', input)
          .then(function (response) {
            if(response.data.success){
              store.dispatch('load_storage', store); 
            }
            store.dispatch('set_prompt', response.data);
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    }
  },
  save_storage (store, input) {
    axios.post('/storage/save', input)
      .then(function (response) {
        if(response.data.success){
          store.dispatch('load_storage', store)
            .then(
              result => {
                console.log('storage save success from axios promise')
                if(store.state.all.length > 1){
                  store.dispatch('close_storage_form', store);
                }else{
                  //TODO COMBINE WITH ITEM ADD
                  var storage_id_default = 0;
                  if(store.rootState.storageSpaces.all.length){
                    storage_id_default = store.rootState.storageSpaces.all[0].storage_id;
                  }
                  store.commit('ADD_ITEM', storage_id_default);
                  store.dispatch('show_item_form', store);
                }    
            });
        }
        store.dispatch('set_prompt', response.data);
      })
      .catch(function (error) {
        console.log(error);
      });
  }
}

const mutations = {
  LOAD_STORAGE (state, storage_spaces) {
    state.all = storage_spaces;
  },
  SET_ACTIVE_STORAGE(state, storage) {
    state.active = storage;
  },
  UPDATE_ACTIVE_STORAGE_PREFIX(state, storage_prefix) {
    state.active.storage_prefix = storage_prefix;
  },
  UPDATE_ACTIVE_STORAGE_NUMBER(state, storage_number) {
    state.active.storage_number = storage_number;
  },
  UPDATE_ACTIVE_STORAGE_NAME(state, storage_name) {
    state.active.storage_name = storage_name;
  },
  ADD_STORAGE (state) {
    const empty_storage = {
      storage_id: 0,
      storage_prefix: 'A',
      storage_number: '1',
      storage_name:'',
      storage_description:''
    }
    state.active = empty_storage
  }
}

export default {
  state,
  actions,
  mutations
}