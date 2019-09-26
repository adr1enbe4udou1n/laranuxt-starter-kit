<template>
  <div class="flex">
    <div class="flex flex-col rounded overflow-hidden shadow-lg">
      <div class="h-64 overflow-hidden">
        <image-cache
          class="w-full h-full object-cover"
          :src="post.featuredImage"
          :alt="post.title"
        ></image-cache>
      </div>
      <div class="px-6 py-4 flex-grow">
        <div class="font-bold text-xl mb-2">{{ post.title }}</div>
        <p class="text-gray-700 text-base">
          {{ post.summary }}
        </p>
      </div>
      <div class="px-6 py-4">
        <span
          v-for="tag in post.tags.data"
          :key="tag.slug"
          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
          ># {{ tag.name }}</span
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
