<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div id="dashboard">
	<div id="no-result" class="splash-container" >
		<div class="splash" v-if="!hasItems">
			&mdash; No Results &mdash;
		</div>
	</div>
	<div id="search-result" class="pure-g">
		<?php echo prompt(); ?>
	    <div id="items" class="box cursor" v-if="hasItems">
			<findr-item
				v-for="item in ajaxData"
				v-bind:itemfromajax="item">
			</findr-item>
		</div>
	</div>
</div>
<findr-item id="findr-item" inline-template v-cloak>
  <transition name="fade">
  	<div class="item pure-g" v-on:click="item_click">
      <div class="pure-u-4-24 photo" v-bind:style="{ 'background-image': 'url(/uploaded-files/' + itemfromajax.filename + ')' }"></div>
  	  <div class="pure-u-16-24 content"><h2>{{ itemfromajax.item_name }}</h2><p>{{ itemfromajax.item_description }}</p></div>
  	  <div class="pure-u-4-24 label">{{ itemfromajax.storage_prefix }} {{ itemfromajax.storage_number }}</div>
    </div>
  </transition>
</findr-item>
