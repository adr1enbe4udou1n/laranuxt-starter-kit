<template>
  <div class="animated fadeIn">
    <b-row class="justify-content-center">
      <b-col xl="4">
        <b-card>
          <h3 class="card-title" slot="header">{{ $route.meta.label }}</h3>
          <b-tabs>
            <b-tab :title="$t('labels.my_account')" active>
              <form @submit.prevent="onSubmitProfile">
                <ProfileForm :model.sync="profile"></ProfileForm>

                <b-btn type="submit" variant="success" size="sm" class="d-block ml-auto" :disabled="pending">
                  {{ $t('buttons.edit') }}
                </b-btn>
              </form>
            </b-tab>
            <b-tab :title="$t('labels.change_password')">
              <form @submit.prevent="onSubmitPassword">
                <PasswordForm :model.sync="password"></PasswordForm>

                <b-btn type="submit" variant="success" size="sm" class="d-block ml-auto" :disabled="pending">
                  {{ $t('buttons.edit') }}
                </b-btn>
              </form>
            </b-tab>
          </b-tabs>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  data() {
    return {
      profile: {
        name: this.$store.state.user.name,
        email: this.$store.state.user.email
      },
      password: {
        old_password: null,
        new_password: null,
        new_password_confirmation: null
      },
      pending: false
    }
  },
  methods: {
    async submit(model, route) {
      this.pending = true

      let form = this.$app.objectToFormData(model)
      form.append('_method', 'PATCH')

      try {
        let { data } = await this.$http.post(this.$app.route(route), form)

        if (data.user) {
          this.$store.commit('setUser', data.user)
        }

        this.password = {
          old_password: null,
          new_password: null,
          new_password_confirmation: null
        }
        this.$bus.$emit('form-errors', {})
      } catch (e) {}

      this.pending = false
    },
    async onSubmitProfile() {
      this.submit(this.profile, 'account.update')
    },
    async onSubmitPassword() {
      this.submit(this.password, 'password.change')
    }
  }
}
</script>
