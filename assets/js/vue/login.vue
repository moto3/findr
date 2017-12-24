<template>
  <div class="splash-container" >
    <div class="splash">
      <transition name="slideUp" appear>
        <div class="splash-inner" v-if="loggedInChecked && !loggedIn">
          <h1 class="header">FIND<span>R</span></h1>
          <h2 class="header">Prototyp<span>e</span></h2>
          <form id="login" v-on:submit.prevent="login_submit">
            <label for="email">{{this.translate('login.email')}}</label>
            <input type="email" name="email" id="email" v-model="email" placeholder="email@findr.com" />
            <label for="password">{{this.translate('login.password')}}</label>
            <input type="password" name="password" id="password" v-model="password" placeholder="password" />
            <input type="submit" :value="this.translate('login.login')" />
          </form>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import formToString from '../vue-mixins/functions'
import translations from '../vue-translations/translations'
import i18n from 'vue-i18n-mixin'
import { mapState } from 'vuex'
import axios from 'axios'

export default {
  mixins: [ formToString, i18n, translations ],
  data() {
    return {
      email: '',
      password: ''
    }
  },
  computed:
    mapState({
      loggedInChecked: state => state.loggedInChecked,
      loggedIn: state => state.loggedIn,
      locale: state => state.locale  
    }),
  methods: {
    login_submit() {
      this.$store.dispatch('login', this.formToString('login'));
    }
  }
}
</script>