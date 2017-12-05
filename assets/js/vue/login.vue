<template>
  <div class="splash-container" >
    <div class="splash">
      <transition name="slideUp" appear>
        <div class="splash-inner" v-if="loggedInChecked && !loggedIn">
          <h1 class="header">FIND<span>R</span></h1>
          <h2 class="header">Prototyp<span>e</span></h2>
          <form id="login" v-on:submit.prevent="login_submit">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" v-model="email" placeholder="email@findr.com" />
            <label for="password">Password</label>
            <input type="password" name="password" id="password" v-model="password" placeholder="password" />
            <input type="submit" value="Log In" />
          </form>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import formToString from '../vue-mixins/functions';
import { mapState } from 'vuex'
import axios from 'axios'
export default {
  mixins: [ formToString ],
  data() {
    return {
      email: '',
      password: ''
    }
  },
  computed: mapState({
    loggedInChecked: state => state.loggedInChecked,
    loggedIn: state => state.loggedIn
  }),
  methods: {
    login_submit() {
      this.$store.dispatch('login', this.formToString('login'));
    }
  }
}
</script>