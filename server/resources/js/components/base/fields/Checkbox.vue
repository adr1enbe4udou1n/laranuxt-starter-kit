<template>
  <b-form-checkbox
    :checked="isChecked"
    :value="value"
    :unchecked-value="uncheckedValue"
    @change="handleChange"
    :switch="this.switch"
  >
    <slot></slot>
  </b-form-checkbox>
</template>

<script>
export default {
  name: 'Checkbox',
  model: {
    prop: 'checked',
    event: 'change'
  },
  props: {
    value: {
      type: Boolean,
      default: true
    },
    uncheckedValue: {
      type: Boolean,
      default: false
    },
    checked: {
      type: Boolean,
      default: false
    },
    switch: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    isChecked() {
      return this.checked === this.value
    }
  },
  methods: {
    handleChange(checked) {
      this.$emit('change', checked ? this.value : this.uncheckedValue)
    }
  }
}
</script>
