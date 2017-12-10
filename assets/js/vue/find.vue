<template>
<div id="find" v-if="this.$store.state.loggedIn">
	<div id="find-inner">
		<div class="pure-g">
			<div class="pure-u-21-24">
			    <input type="text" id="fld_find" name="find" placeholder="Find something..." @input="find_item" />
			</div>
			<div class="pure-u-3-24">
			    <input type="button" id="btn_find" />
			</div>
		</div>
	</div>
</div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
export default {
  methods: {
    ...mapActions([
      'find_item'
    ]),
    local_method(e) {
      
    }
  }
}
</script>