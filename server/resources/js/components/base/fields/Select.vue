<template>
  <div>
    <b-form-select
      :id="getId"
      :name="name"
      :value="value"
      :options="getOptions"
      :multiple="multiple"
      :state="state"
      @change="handleChange"
    >
    </b-form-select>
    <b-form-invalid-feedback v-if="invalidFeedback"> {{ invalidFeedback }} </b-form-invalid-feedback>
    <b-form-text v-if="description">{{ description }}</b-form-text>
  </div>
</template>

<script>
import field from '@/mixins/field'

export default {
  name: 'Select',
  mixins: [field],
  model: {
    prop: 'value',
    event: 'change'
  },
  props: {
    value: {
      type: [String, Number, Object, Array, Boolean],
      default: () => {}
    },
    options: {
      type: [Array, Object],
      default: () => []
    },
    multiple: {
      type: Boolean,
      default: false
    },
    placeholder: {
      type: String,
      default: ''
    },
    label: {
      type: [String, Function],
      default: null
    },
    column: {
      type: String,
      default: null
    },
    direction: {
      type: String,
      default: 'asc'
    },
    trackBy: {
      type: String,
      default: 'id'
    },
    modelRoute: {
      type: String,
      default: null
    },
    modelRouteQuery: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      items: []
    }
  },
  computed: {
    getOptions() {
      if (!this.placeholder) {
        return this.items
      }
      if (this.items instanceof Array) {
        return [{ value: null, text: this.placeholder }, ...this.items]
      }
      return { null: this.placeholder, ...this.items }
    }
  },
  watch: {
    options: {
      async handler(newValue) {
        this.items = newValue
      },
      immediate: true
    }
  },
  async mounted() {
    if (this.modelRoute === null) {
      return
    }

    let { data } = await this.$http.get(
      this.$app.route(
        `${this.modelRoute}.index`,
        Object.assign(
          {
            column: this.column || this.label,
            direction: this.direction,
            perPage: 50
          },
          this.modelRouteQuery
        )
      )
    )

    this.items = data.data.map((item) => {
      return {
        text: this.getLabel(item),
        value: item[this.trackBy]
      }
    })
  },
  methods: {
    handleChange(value) {
      this.$emit('change', value)
    },
    getLabel(item) {
      if (typeof item === 'string') {
        return item
      }
      if (typeof this.label === 'function') {
        return this.label(item)
      }
      return item[this.label]
    }
  }
}
</script>
