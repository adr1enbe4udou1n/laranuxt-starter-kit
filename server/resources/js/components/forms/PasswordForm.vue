<template>
  <div>
    <FormGroup label-for="old-password">
      <InputType name="old_password" type="password" v-model="model.old_password"> </InputType>
    </FormGroup>

    <FormGroup label-for="new-password">
      <InputType name="new_password" type="password" v-model="model.new_password"> </InputType>
    </FormGroup>

    <FormGroup label-for="new-password-confirmation">
      <InputType name="new_password_confirmation" type="password" v-model="model.new_password_confirmation">
      </InputType>
    </FormGroup>
  </div>
</template>

<script>
import form from '@/mixins/form'

export default {
  name: 'PasswordForm',
  mixins: [form]
}
</script>
