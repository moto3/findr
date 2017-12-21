<template>
<div id="prompt-wrapper">
  <transition name="slideAway" appear>
    <div id="prompt" v-if="showPrompt" v-bind:class="{message: true, error: isError}">
      {{this.translate(message)}}
    </div>
  </transition>
</div>
</template>

<script>
  import translations from '../vue-translations/translations'
  import i18n from 'vue-i18n-mixin'
  import {mapState} from 'vuex'

  export default {
    mixins: [ i18n, translations ],
    computed:
      mapState({
        locale: state => state.locale,
        showPrompt: state => state.prompt.message.length,
        isError: state => state.prompt.isError,
        message: state => state.prompt.message,
      })
  }
</script>