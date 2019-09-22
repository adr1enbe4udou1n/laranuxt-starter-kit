<template>
  <div>
    <b-form-radio-group
      :checked="value"
      @change="handleChange"
      :name="name"
      :options="options"
      :state="state"
      :stacked="stacked"
    >
    </b-form-radio-group>
    <b-form-invalid-feedback v-if="invalidFeedback" :class="{ 'd-block': !!invalidFeedback }">
      {{ invalidFeedback }}
    </b-form-invalid-feedback>
    <b-form-text v-if="description">{{ description }}</b-form-text>
  </div>
</template>

<script>
import field from '@/mixins/field'

export default {
  name: 'Radios',
  mixins: [field],
  model: {
    prop: 'value',
    event: 'change'
  },
  props: {
    value: {
      type: [String, Number, Object, Boolean],
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
