<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div id="prompt-wrapper">
  <transition name="slideAway">
    <div id="prompt" v-if="isShown" v-bind:class="{message: true, error: isError}">
      {{message}}
    </div>
  </transition>
</div>