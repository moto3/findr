<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="vue-modal" v-cloak>
	<transition name="fade" v-on:after-enter="afterEnter">
		<div id="modal" class="modal" v-if="show" v-on:click.self="close_modal">

			<transition name="slideUp">
				<div id="item-add" class="pure-g" v-if="panel_on">

					<div class="box">

						<div class="pure-u-5-5">
							<?php echo form_open_multipart('/items/add');?>
								<label class="btn btn-photo" id="lbl-fileupload" for="fileupload">Upload photos...</label>
						    	<input id="fileupload" type="file" name="files" style="display:none;" />
							</form>
					    </div>
					    <?php echo form_open_multipart('/items/save','id="item_form" @submit.prevent="submit_form"'); ?>
					    <div class="pure-u-5-5">
					    	<div id="files" class="files"></div>

					    	<photo-preview v-for="photo in ajaxPhotos" v-bind:photodata="photo">
							</photo-preview>

					    	<input type="text" name="uploaded_files" v-bind:value="uploadedFiles" style="font-size:8px;padding:0;margin-bottom:1px;" />
						</div>
						<div class="pure-u-5-5">
							<label>Storage</label>
						</div>
						<div class="pure-u-1-5">
							<select id="prefix" name="prefix" v-model="storagePrefix">
								<option v-for="alphabet in alphabets" v-bind:value="alphabet.value">
    								{{ alphabet.letter }}
  								</option>
							</select>
						</div>
						<div class="pure-u-4-5">
							<select id="number" name="number" v-model="storageNumber">
								<option v-for="number in numbers" v-bind:value="number.value">
    								{{ number.digit }}
  								</option>
							</select>
						</div>
						<div class="pure-u-5-5">
							<label for="name">Name</label>
							<input type="text" id="item_id" name="item_id" :value="itemId" style="font-size:8px;padding:0;margin-bottom:1px;" />
							<input type="text" id="name" name="name" v-validate="{required: true}" :class="{'error': errors.has('name') }" :value="itemName" />
							<span v-if="errors.has('name')" class="error">
						        {{ errors.first('name') }}
						    </span>
						</div>
						<div class="pure-u-5-5">
							<label for="description">Description</label>
							<textarea id="description" name="description" v-model="itemDescription">{{itemDescription}}</textarea>
						</div>
						<div class="pure-u-5-5">
							<input type="submit" value="SAVE" :disabled="errors.any()" />
						</div>
						</form>
					</div>
				</div>
			</transition>
		</div>
	</transition>
</div>
<photo-preview id="photo-preview" inline-template v-cloak>
  <span class="photo-preview" v-bind:title="photodata.name" v-bind:style="{ 'background-image': 'url(/uploaded-files/' + photodata.name + ')' }"></span>
</photo-preview>
