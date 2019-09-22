<template>
  <div>
    <FormGroup label-for="name">
      <InputType name="name" v-model="model.name"> <i slot="prepend" class="fe fe-user"></i> </InputType>
    </FormGroup>

    <FormGroup label-for="email">
      <InputType name="email" type="email" v-model="model.email"> <i slot="prepend" class="fe fe-mail"></i> </InputType>
    </FormGroup>

    <FormGroup>
      <Checkbox v-model="model.active" switch>
        {{ $t('attributes.active') }}
      </Checkbox>
    </FormGroup>

    <FormGroup label-for="roles">
      <Checkboxes name="roles" :options="$app.enums.role_enum" v-model="model.roles" stacked> </Checkboxes>
    </FormGroup>

    <FormGroup>
      <Checkbox v-model="model.reset_password"> {{ $t('labels.reset_password') }} </Checkbox>
    </FormGroup>
  </div>
</template>

<script>
import form from '@/mixins/form'

export default {
  name: 'UserForm',
  mixins: [form]
}
</script>
