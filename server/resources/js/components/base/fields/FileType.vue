<template>
  <div>
    <b-form-file
      :id="getId"
      :name="name"
      ref="fileInput"
      :accept="accept"
      :placeholder="$t('labels.select_file')"
      :state="state"
      @input="input"
    ></b-form-file>
    <b-form-invalid-feedback v-if="invalidFeedback"> {{ invalidFeedback }} </b-form-invalid-feedback>
    <b-form-text v-if="description">{{ description }}</b-form-text>
    <b-form-text v-if="fileUrl">
      <a :href="fileUrl" target="_blank" class="mr-4"> {{ $t('labels.file_link') }} </a>
      <div class="d-inline-flex">
        <Checkbox @change="onDelete"> {{ $t('labels.delete') }} </Checkbox>
      </div>
    </b-form-text>
  </div>
</template>

<script>
import field from '@/mixins/field'

export default {
  name: 'FileType',
  mixins: [field],
  props: {
    value: {
      type: [String, File],
      default: null
    },
    id: {
      type: String,
      default: ''
    },
    accept: {
      type: String,
      default: ''
    },
    description: {
      type: String,
      default: ''
    },
    fileUrl: {
      type: String,
      default: ''
    }
  },
  methods: {
    input(value) {
      this.$emit('input', value)
    },
    reset() {
      this.$refs.fileInput.reset()
    },
    onDelete(value) {
      this.$emit('update:delete', value)
    }
  }
}
</script>
