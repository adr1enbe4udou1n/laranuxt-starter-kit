/**
 * Mixin for forms
 */

export default {
  props: {
    model: {
      type: [Object, Array],
      default: () => {}
    },
    prefixName: {
      type: String,
      default: ''
    }
  },
  watch: {
    model: {
      handler(val) {
        this.$emit('update:model', val)
      },
      deep: true
    }
  }
}
