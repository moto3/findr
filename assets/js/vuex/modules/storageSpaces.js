import axios from 'axios'

const state = {
  all: [],
  active: {}
}

const actions = {
  load_storage({commit}) {
    axios.post('/storage/load')
    .then(function (response) {
      if(response.data.length > 0){
        commit('LOAD_STORAGE', response.data);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
  },
  set_active_storage (store, storage) {
    store.commit('SET_ACTIVE_STORAGE', storage);
  },
  add_new_storage (store, storage) {
    store.dispatch('show_storage_form');
    store.commit('ADD_STORAGE');
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
        var input = 'storage_id=' + store.state.active.storage_id;
        axios.post('/storage/delete', input)
          .then(function (response) {
            if(response.data.success){
              store.dispatch('load_storage', store); 
            }
            var prompt_data = {message:response.data.message, error:!response.data.success}
            store.dispatch('set_prompt', prompt_data);
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
          var prompt_data = {message:'Storage saved successfully.', error:false};
          store.dispatch('load_storage', store);
          store.dispatch('close_storage_form', store);
        }else{
          var prompt_data = {message:response.data.message, error:true};
        }
        store.dispatch('set_prompt', prompt_data);
        
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