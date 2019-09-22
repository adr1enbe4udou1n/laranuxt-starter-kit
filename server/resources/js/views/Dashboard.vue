<template>
  <b-row class="justify-content-center">
    <b-col sm="3">
      <b-card bg-variant="primary" text-variant="white" body-class="p-4">
        <h3 class="mb-0">
          <b-spinner type="grow" v-if="users === null"></b-spinner>
          {{ users }}
        </h3>
        <p class="mb-0">Utilisateurs actifs</p>
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      users: null
    }
  },
  created() {
    this.getCounter('users', 'user', { active: 1 })
  },
  methods: {
    async getCounter(type, model, params) {
      let { data } = await this.$http.get(window.route('counter', model), {
        params
      })

      this[type] = data.count
    }
  }
}
</script>
