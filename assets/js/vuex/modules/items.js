import axios from 'axios'

const state = {
  all: [],
  filtered: [],
  active: {}
}

const actions = {
  load_items (store) {
    axios.post('/items/load')
    .then(function (response) {
      if(response.data.length > 0){
        response.data.map((obj) => {
          obj.active = true;
          return obj;
        });
        console.log(response.data);
        store.commit('LOAD_ITEMS', response.data);
        store.dispatch('find_item_evoke');
      }
    })
    .catch(function (error) {
      console.log(error);
    });
  },
  remove_one ({commit}) {
    commit('REMOVE_ONE');
  },
  add_new_item (store) {
    var storage_id_default = 0;
    if(store.rootState.storageSpaces.all.length){
      storage_id_default = store.rootState.storageSpaces.all[0].storage_id;
    }
    store.commit('ADD_ITEM', storage_id_default);
    store.dispatch('open_form', store);
  },
  set_active_item (store, item) {
    store.commit('SET_ACTIVE_ITEM', item);
    store.dispatch('open_form', store);
  },
  upload_image (store) {
    var data = new FormData();
    data.append('files', document.getElementById('fileupload').files[0]);
    axios.post('/items/image_upload', data, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    .then(function (response) {
      var photoPreview = {};
      photoPreview.photoId = response.data.files[0].photoId;
      photoPreview.fileName = response.data.files[0].fileName;
      photoPreview.thumbName = response.data.files[0].thumbName;
      store.commit('ADD_ACTIVE_ITEM_PHOTO', photoPreview);
      var prompt_data = {message:'Image uploaded successfully.', error:false};
      store.dispatch('set_prompt', prompt_data);
    })
    .catch(function (error) {
      console.log(error)
    });
  },
  item_form_submit (store, input) {
    console.log('submit')
    axios.post('/items/save', input)
    .then(function (response) {
      store.dispatch('load_items', store);
      store.dispatch('close_form', store);
      var prompt_data = {message:'Item saved successfully.', error:false};
      store.dispatch('set_prompt', prompt_data);
    })
    .catch(function (error) {
      console.log(error);
    });
  }
}

const mutations = {
  LOAD_ITEMS (state, items) {
    state.all = items;
  },
  SET_FILTERED_ITEMS (state, filtered_items) {
    state.filtered = filtered_items;
  },
  SET_ACTIVE_ITEM (state, item) {
    state.active = item;
  },
  ADD_ITEM (state, storage_id_default) {
    const empty_item = {
      photos: [],
      item_id: 0,
      item_name: '',
      item_description: '',
      storage_id:0,
      storage_prefix: 'A',
      storage_number: '1'
    }
    empty_item.storage_id = storage_id_default;
    state.active = empty_item
  },
  ADD_ACTIVE_ITEM_PHOTO (state, photo) {
    state.active.photos.push(photo)
  },
  UPDATE_ACTIVE_STORAGE_ID (state, value) {
    state.active.storage_id = value
  },
  UPDATE_ACTIVE_ITEM_NAME (state, value ) {
    state.active.item_name = value
  },
  UPDATE_ACTIVE_ITEM_DESCRIPTION (state, value ) {
    state.active.item_description = value
  }
}

const getters = {
  get_items: (state, getters, rootState) => {
    if(rootState.isSearching){
      return state.filtered
    }else{
      return state.all
    }
  }
}

export default {
  state,
  actions,
  getters,
  mutations
}