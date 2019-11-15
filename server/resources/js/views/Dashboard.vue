<template>
  <b-row class="justify-content-center">
    <b-col sm="3">
      <b-card bg-variant="success" text-variant="white" body-class="p-4">
        <h3 class="mb-0">
          <b-spinner type="grow" v-if="publishedPosts === null"></b-spinner>
          {{ publishedPosts }}
        </h3>
        <p class="mb-0">{{ $t('labels.published_posts') }}</p>
      </b-card>
    </b-col>
    <b-col sm="3">
      <b-card bg-variant="danger" text-variant="white" body-class="p-4">
        <h3 class="mb-0">
          <b-spinner type="grow" v-if="draftPosts === null"></b-spinner>
          {{ draftPosts }}
        </h3>
        <p class="mb-0">{{ $t('labels.draft_posts') }}</p>
      </b-card>
    </b-col>
    <b-col sm="3">
      <b-card bg-variant="primary" text-variant="white" body-class="p-4">
        <h3 class="mb-0">
          <b-spinner type="grow" v-if="users === null"></b-spinner>
          {{ users }}
        </h3>
        <p class="mb-0">{{ $t('labels.active_users') }}</p>
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      publishedPosts: null,
      draftPosts: null,
      users: null
    }
  },
  created() {
    this.getCounter('users', 'user', { active: 1 })
    this.getCounter('publishedPosts', 'post', { type: 'post', status: 'published' })
    this.getCounter('draftPosts', 'post', { type: 'post', status: 'draft' })
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
