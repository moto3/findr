<template>
  <div id="find" v-if="this.$store.state.loggedIn">
  	<div id="find-inner">
  		<div class="pure-g">
  			<div class="pure-u-21-24">
  			    <input type="text" id="fld_find" name="find" :placeholder="this.translate('find.find_something')" @input="find_item" />
  			</div>
  			<div class="pure-u-3-24">
  			    <input type="button" id="btn_find" />
  			</div>
  		</div>
  	</div>
  </div>
</template>

<script>
import translations from '../vue-translations/translations'
import i18n from 'vue-i18n-mixin'
import {mapState, mapActions, mapGetters} from 'vuex'

export default {
  mixins: [ i18n, translations ],
  computed:
    mapState({
      locale: state => state.locale  
    }),
  methods: 
    mapActions([
      'find_item'
    ])
}
</script>