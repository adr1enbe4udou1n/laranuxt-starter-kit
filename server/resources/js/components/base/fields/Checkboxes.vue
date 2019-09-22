<template>
  <div>
    <b-form-checkbox-group :stacked="stacked" :checked="value" @change="handleChange" :name="name" :options="options">
    </b-form-checkbox-group>
    <b-form-invalid-feedback v-if="invalidFeedback" :class="{ 'd-block': !!invalidFeedback }">
      {{ invalidFeedback }}
    </b-form-invalid-feedback>
    <b-form-text v-if="description">{{ description }}</b-form-text>
  </div>
</template>

<script>
import field from '@/mixins/field'

export default {
  name: 'Checkboxes',
  mixins: [field],
  model: {
    prop: 'value',
    event: 'change'
  },
  props: {
    value: {
      type: [Object, Array],
      default: () => {}
    },
    stacked: {
      type: Boolean,
      default: false
    },
    options: {
      type: [Array, Object],
      default: () => []
    }
  },
  methods: {
    handleChange(value) {
      this.$emit('change', value)
    }
  }
}
</script>
