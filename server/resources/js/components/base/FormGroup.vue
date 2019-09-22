<template>
  <b-form-group :label="getLabel" :label-for="labelFor" label-class="form-label" :description="description">
    <slot></slot>
  </b-form-group>
</template>

<script>
export default {
  name: 'FormGroup',
  props: {
    label: {
      type: String,
      default: ''
    },
    labelFor: {
      type: String,
      default: ''
    },
    description: {
      type: String,
      default: ''
    }
  },
  computed: {
    getName() {
      return this.labelFor.replace(/-/g, '_')
    },
    getLabel() {
      if (this.labelFor) {
        return this.label || this.$t(`attributes.${this.getName}`)
      }
      return this.label
    }
  }
}
</script>
