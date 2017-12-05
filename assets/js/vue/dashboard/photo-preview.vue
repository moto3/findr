<template>
  <span class="photo-preview" v-bind:title="photodata.filename" v-bind:style="{ 'background-image': 'url(/uploaded-files/thumbs/' + photodata.thumbName + ')' }"></span>
</template>
<script>
export default {
  props: ['photodata']
}
</script>