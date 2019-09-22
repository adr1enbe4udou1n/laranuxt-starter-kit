<template>
  <div>
    <b-input-group>
      <flat-pickr
        :id="getId"
        :name="name"
        :config="config"
        :placeholder="placeholder"
        class="form-control text-right"
        v-model="mutableValue"
      ></flat-pickr>
      <b-input-group-append>
        <b-input-group-text data-toggle style="cursor: pointer"> <i class="fe fe-calendar"></i> </b-input-group-text>
        <b-input-group-text data-clear style="cursor: pointer"> <i class="fe fe-x-circle"></i> </b-input-group-text>
      </b-input-group-append>
    </b-input-group>
    <b-form-invalid-feedback v-if="invalidFeedback" :class="{ 'd-block': !!invalidFeedback }">
      {{ invalidFeedback }}
    </b-form-invalid-feedback>
    <b-form-text v-if="description">{{ description }}</b-form-text>
  </div>
</template>

<script>
import field from '@/mixins/field'
import flatPickr from 'vue-flatpickr-component'
import { French } from 'flatpickr/dist/l10n/fr.js'

export default {
  name: 'DateTimePicker',
  components: {
    flatPickr
  },
  mixins: [field],
  props: {
    value: {
      type: [String, Date],
      default: null
    },
    enableTime: {
      type: Boolean,
      default: true
    },
    placeholder: {
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
      mutableValue: null,
      config: {
        wrap: true,
        time_24hr: true,
        enableTime: this.enableTime,
        locale: French
      }
    }
  },
  watch: {
    mutableValue(newValue) {
      this.$emit('input', newValue)
    },
    value: {
      handler(newValue) {
        this.mutableValue = newValue
      },
      immediate: true
    }
  }
}
</script>
