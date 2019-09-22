<template>
  <div>
    <FormGroup label-for="name">
      <InputType name="name" v-model="model.name"></InputType>
    </FormGroup>
  </div>
</template>

<script>
import form from '@/mixins/form'

export default {
  name: 'TagForm',
  mixins: [form]
}
</script>
