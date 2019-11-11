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
                {{ $t('buttons.edit') }}
              </b-btn>
              <b-btn
                size="sm"
                variant="warning"
                class="ml-1"
                v-if="
                  !$route.meta.model.is_owner &&
                    $route.meta.model.id !== this.$store.state.user.id &&
                    this.$store.state.user.is_admin
                "
                :href="$app.route('users.impersonate', { user: $route.meta.model.id })"
                :title="$t('labels.login_as')"
              >
                <i class="fe fe-lock"></i>
              </b-btn>
              <b-btn size="sm" variant="danger" @click="onDelete" class="ml-1">
                {{ $t('buttons.delete') }}
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
  name: 'UserEdit',
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
