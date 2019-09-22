<template>
  <b-media v-if="layout === 'media'">
    <div v-if="fileUrl" slot="aside">
      <ImageCache size="ap" :src="fileUrl" fluid thumbnail></ImageCache>
    </div>
    <FileType
      ref="fileInput"
      :id="id"
      :name="name"
      :accept="accept"
      :description="description"
      :file-url="fileUrl"
      @update:delete="onDelete"
      @input="input"
    ></FileType>
  </b-media>
  <div v-else-if="layout === 'card'">
    <div v-if="fileUrl" class="mb-2">
      <ImageCache size="sm" :src="fileUrl" fluid thumbnail></ImageCache>
    </div>
    <FileType
      ref="fileInput"
      :id="id"
      :name="name"
      :accept="accept"
      :description="description"
      :file-url="fileUrl"
      @update:delete="onDelete"
      @input="input"
    ></FileType>
  </div>
</template>

<script>
export default {
  name: 'ImageType',
  props: {
    value: {
      type: [String, File],
      default: null
    },
    id: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: ''
    },
    accept: {
      type: String,
      default: ''
    },
    description: {
      type: String,
      default: ''
    },
    fileUrl: {
      type: String,
      default: ''
    },
    layout: {
      type: String,
      default: 'media',
      validator: (val) => ['media', 'card'].includes(val)
    }
  },
  methods: {
    input(value) {
      this.$emit('input', value)
    },
    reset() {
      this.$refs.fileInput.reset()
    },
    onDelete(value) {
      this.$emit('update:delete', value)
    }
  }
}
</script>
