<template>
  <img
    v-lazy="imageCachePath"
    :alt="alt"
    :width="width"
    :height="width"
    src="/blank.gif"
  />
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
    width: {
      type: Number,
      default: null
    },
    height: {
      type: Number,
      default: null
    },
    size: {
      type: String,
      default: 'md',
      validator: (val) => ['xs', 'sm', 'md', 'lg', 'xl'].includes(val)
    },
    method: {
      type: String,
      default: 'max',
      validator: (val) => ['max', 'crop'].includes(val)
    },
    query: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    formattedSize() {
      return {
        xs: 'extra_small',
        sm: 'small',
        md: 'medium',
        lg: 'large',
        xl: 'extra_large'
      }[this.size]
    },
    imageCachePath() {
      return `${process.env.MEDIA_CACHE_URL}${this.src.replace(
        /^.*\/\/[^/]+/,
        ''
      )}?${qs.stringify({
        method: this.method,
        size: this.formattedSize,
        ...this.query
      })}`
    }
  }
}
</script>
