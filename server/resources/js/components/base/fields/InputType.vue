<template>
  <div>
    <b-input-group :size="size">
      <b-input-group-prepend v-if="this.$slots.prepend">
        <b-input-group-text> <slot name="prepend"></slot> </b-input-group-text>
      </b-input-group-prepend>
      <b-form-input
        :id="getId"
        :name="name"
        :type="type"
        :placeholder="placeholder"
        :value="value"
        @input="input"
        :state="state"
      ></b-form-input>
      <b-input-group-append v-if="this.$slots.append">
        <b-input-group-text> <slot name="append"></slot> </b-input-group-text>
      </b-input-group-append>
    </b-input-group>
  </div>
</template>

<script>
import field from '@/mixins/field'

export default {
  name: 'InputType',
  mixins: [field],
  props: {
    value: {
      type: [String, Number, Date],
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
    size: {
      type: String,
      default: ''
    }
  },
  methods: {
    input(value) {
      this.$emit('input', value)
    }
  }
}
</script>
