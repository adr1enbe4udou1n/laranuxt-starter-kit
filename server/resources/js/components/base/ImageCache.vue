<template>
  <b-img :src="imageCachePath" :alt="alt" :fluid="fluid" :thumbnail="thumbnail"></b-img>
</template>

<script>
import qs from 'qs'

export default {
  name: 'ImageCache',
  props: {
    src: {
      type: String,
      required: true
    },
    alt: {
      type: String,
      default: ''
    },
    fluid: {
      type: Boolean,
      default: false
    },
    thumbnail: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'md',
      validator: (val) => ['ap', 'xs', 'sm', 'md', 'lg', 'xl'].includes(val)
    }
  },
  computed: {
    formattedSize() {
      return {
        ap: 'admin_preview',
        xs: 'extra_small',
        sm: 'small',
        md: 'medium',
        lg: 'large',
        xl: 'extra_large'
      }[this.size]
    },
    imageCachePath() {
      return `/media/cache${this.src.replace(/^.*\/\/[^\/]+/, '')}?${qs.stringify({
        p: this.formattedSize
      })}`
    }
  }
}
</script>
