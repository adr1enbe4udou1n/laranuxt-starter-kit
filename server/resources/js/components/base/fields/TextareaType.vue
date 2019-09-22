<template>
  <div>
    <b-form-textarea
      :id="getId"
      :name="name"
      :placeholder="placeholder"
      :value="value"
      @input="input"
      :state="state"
      :rows="rows"
    ></b-form-textarea>
    <b-form-invalid-feedback v-if="invalidFeedback"> {{ invalidFeedback }} </b-form-invalid-feedback>
    <b-form-text v-if="description">{{ description }}</b-form-text>
  </div>
</template>

<script>
import field from '@/mixins/field'

export default {
  name: 'TextareaType',
  mixins: [field],
  props: {
    value: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    placeholder: {
      type: String,
      default: ''
    },
    rows: {
      type: Number,
      default: 5
    }
  },
  methods: {
    input(value) {
      this.$emit('input', value)
    }
  }
}
</script>
