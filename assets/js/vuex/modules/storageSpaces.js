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
    store.commit('ADD_STORAGE');
  },
  storage_submit (store, input) {
    axios.post('/storage/save', input)
      .then(function (response) {
        store.dispatch('load_storage', store);
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