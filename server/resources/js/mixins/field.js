/**
 * Mixin for validations
 */

export default {
  props: {
    id: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: ''
    },
    description: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      state: null,
      invalidFeedback: null
    }
  },
  computed: {
    getId() {
      return this.id || this.name.replace(/_/g, '-').replace(/\./g, '__')
    }
  },
  created() {
    this.$bus.$on('form-errors', (errors) => {
      this.state = null
      this.invalidFeedback = null

      if (errors.hasOwnProperty(this.name)) {
        this.state = false
        this.invalidFeedback = errors[this.name][0]
      }
    })
  }
}
