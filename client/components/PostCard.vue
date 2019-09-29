<template>
  <div class="flex">
    <div class="flex flex-col rounded overflow-hidden shadow-lg">
      <div class="h-64 overflow-hidden">
        <nuxt-link :to="{ name: 'post', params: { slug: post.slug } }">
          <image-cache
            class="w-full h-full object-cover"
            :src="post.featuredImage"
            :alt="post.title"
          ></image-cache>
        </nuxt-link>
      </div>
      <div class="px-6 py-4 flex-grow">
        <nuxt-link :to="{ name: 'post', params: { slug: post.slug } }">
          <h3 class="font-bold text-xl mb-2">{{ post.title }}</h3>
        </nuxt-link>
        <p class="text-gray-700 text-base">
          {{ post.summary }}
        </p>
      </div>
      <div class="px-6 py-4">
        <nuxt-link
          v-for="tag in post.tags.data"
          :key="tag.slug"
          :to="{ name: 'tag', params: { tag: tag.slug } }"
          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
          ># {{ tag.name }}</nuxt-link
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    post: {
      type: Object,
      default: () => {}
    }
  }
}
</script>

<style></style>
