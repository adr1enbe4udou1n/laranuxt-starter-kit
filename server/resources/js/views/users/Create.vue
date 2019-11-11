<template>
  <div class="animated fadeIn">
    <b-row class="justify-content-center">
      <b-col xl="3">
        <b-card>
          <h3 class="card-title" slot="header">{{ $route.meta.label }}</h3>
          <form @submit.prevent="onSubmit">
            <UserForm :model.sync="model"></UserForm>
            <div class="d-flex">
              <b-btn to="/users" exact variant="primary" size="sm"> {{ $t('buttons.back') }} </b-btn>
              <b-btn type="submit" variant="success" size="sm" :disabled="pending" class="ml-auto">
                {{ $t('buttons.create') }}
              </b-btn>
            </div>
          </form>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { model } from '@/mixins/model'

export default {
  name: 'UserCreate',
  mixins: [model('users')],
  data() {
    return {
      model: {
        name: null,
        email: null,
        active: true,
        roles: [],
        reset_password: false
      }
    }
  }
}
</script>
