export default {
  methods: {
    formToString( form_id ) {
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
  }
}
