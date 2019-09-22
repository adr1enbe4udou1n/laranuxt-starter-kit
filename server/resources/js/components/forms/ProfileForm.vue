<template>
  <div>
    <FormGroup label-for="name">
      <InputType name="name" v-model="model.name"> <i slot="prepend" class="fe fe-user"></i> </InputType>
    </FormGroup>

    <FormGroup label-for="email">
      <InputType name="email" type="email" v-model="model.email"> <i slot="prepend" class="fe fe-mail"></i> </InputType>
    </FormGroup>
  </div>
</template>

<script>
import form from '@/mixins/form'

export default {
  name: 'ProfileForm',
  mixins: [form]
}
</script>
