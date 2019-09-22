<template>
  <div class="animated fadeIn">
    <form @submit.prevent="onSubmit">
      <PostForm :model.sync="model" :pending="pending" @submit="onSubmit"></PostForm>
    </form>
  </div>
</template>

<script>
import { model } from '@/mixins/model'

export default {
  name: 'PostCreate',
  mixins: [model('posts')],
  data() {
    return {
      model: {
        title: null,
        type: 'page',
        slug: null,
        summary: null,
        body: null,
        status: null,
        status_label: null,
        status_badge: null,
        publication_date: null,
        tags: [],
        featured_image: null,
        featured_image_file: null,
        featured_image_delete: false,
        user_id: null
      }
    }
  },
  methods: {
    onSuccess() {
      this.$router.push(`/pages`)
    }
  }
}
</script>
