<template>
  <div class="animated fadeIn">
    <form @submit.prevent="onSubmit">
      <PostForm :model.sync="model" :pending="pending" :is-edit="true" @delete="onDelete" @submit="onSubmit"></PostForm>
    </form>
  </div>
</template>

<script>
import { model } from '@/mixins/model'

export default {
  name: 'PostEdit',
  mixins: [model('posts')],
  data() {
    return {
      model: {
        title: null,
        type: null,
        slug: null,
        summary: null,
        body: null,
        status: null,
        status_label: null,
        status_badge: null,
        publication_date: null,
        is_pinned: false,
        tags: [],
        featured_image: null,
        featured_image_file: null,
        featured_image_delete: false,
        user_id: null
      }
    }
  }
}
</script>
