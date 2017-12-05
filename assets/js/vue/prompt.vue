<template>
<div id="prompt-wrapper">
  <transition name="slideAway" appear>
    <div id="prompt" v-if="showPrompt" v-bind:class="{message: true, error: isError}">
      {{message}}
    </div>
  </transition>
</div>
</template>

<script>
  import {mapState} from 'vuex'
  export default {
    computed: mapState({
      showPrompt: state => state.prompt.message.length,
      message: state => state.prompt.message,
      isError: state => state.prompt.isError
    })
  }
</script>