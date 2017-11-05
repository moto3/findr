var prompt_timer = 2000;
$(function(){

	setTimeout(function(){
		$("#prompt").slideUp();
	}, prompt_timer);

	$("#bottom-widget .btn-add").click(function(){
		window.location = '/items/add';
	});

  var url = '/items/image-upload/';
  $('#fileupload').fileupload({
      url: url,
      dataType: 'json',
      send: function (e, data) {
        $(".btn-photo").addClass('loading');
      },
      done: function (e, data) {
        if (data.result.error) {
          console.log(data.result.error);
        }else{
          $.each(data.result.files, function (index, file) {
            modal.load_photo_previews(file);
            modal.uploadedFiles = file.name + "," + modal.uploadedFiles;
            $(".btn-photo").removeClass('loading');
          });
        }
      }
    }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');

  Vue.use(VeeValidate);
  Vue.component('findr-item', {
    template: '#findr-item',
    props: [ 'itemfromajax' ],
    methods: {
      item_click() {
        modal.set_form(this.itemfromajax);
        modal.show = true;
      }
    }
  });
  var dashboard = new Vue({
    el: '#dashboard',
    data: {
      ajaxData: [],
      hasItems: false
    },
    methods: {
      load_items() {
        axios.post('/items/load')
        .then(function (response) {
          if(response.data.length){
            dashboard.hasItems = true;
            dashboard.ajaxData = response.data;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
      }
    },
    created: function () {
      this.load_items();
    }
  });

  var bottom_widgets = new Vue({
    el: '#bottom-widgets',
    methods: {
      open_item_add() {
        modal.reset_form();
        modal.show = true;
      }
    }
  });
  
  Vue.component('photo-preview', {
    template: '#photo-preview',
    props: ['photodata']
  });
  var data_alphabets = [];
  var str_alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  for(i=0; i < str_alphabets.length; i++){
    data_alphabets.push({letter:str_alphabets.charAt(i), value:str_alphabets.charAt(i)});
  }
  var data_numbers = [];
  for(i=1; i <= 99; i++){
    data_numbers.push({digit:i, value:i});
  }

  var modal = new Vue({
    el: '#vue-modal',
    data: {
      show:false,
      panel_on:false,
      ajaxPhotos: [],
      alphabets: data_alphabets,
      numbers: data_numbers
    },
    methods: {
      afterEnter() {
        modal.panel_on = true;
      },
      close_modal() {
        modal.show = false;
        modal.panel_on = false;
      },
      load_photo_previews(file) {
        modal.ajaxPhotos.push(file);
      },
      submit_form() {
        this.$validator.validateAll().then((result) => {
          if (result) {
            axios.post('/items/save', toJSONString('item_form'))
            .then(function (response) {
                modal.close_modal();
                dashboard.load_items();
            })
            .catch(function (error) {
                console.log(error);
            });
            return;
          }
        });
      },
      reset_form() {
        modal.ajaxPhotos = [];
        modal.itemId = '';
        modal.uploadedFiles = '';
        modal.storagePrefix = modal.alphabets[0].letter;
        modal.storageNumber = modal.numbers[0].digit;
        modal.itemName = '';
        modal.itemDescription = '';
      },
      set_form(form_data) {
        console.log(form_data);
        modal.ajaxPhotos = [{name:form_data.filename}];
        modal.itemId = form_data.item_id;
        modal.storagePrefix = form_data.storage_prefix;
        modal.storageNumber = form_data.storage_number;
        modal.itemName = form_data.item_name;
        modal.itemDescription = form_data.item_description;
      }
    }
  });
  function toJSONString( form_id ) {
    var form = document.getElementById( form_id );
    var ret = '';
    var elements = form.querySelectorAll( "input, select, textarea" );
    for( var i = 0; i < elements.length; ++i ) {
      var element = elements[i];
      var name = element.name;
      var value = element.value;
      if( name ) {
        ret += encodeURIComponent(element.name) + "=" + encodeURIComponent(element.value) + "&";
      }
    }
    return ret;
  }

});

