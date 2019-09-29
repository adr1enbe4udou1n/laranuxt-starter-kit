<template>
  <page>
    <div slot="hero">
      <div class="container mx-auto py-20 text-center">
        <h1 class="text-center text-4xl uppercase mb-3">{{ post.title }}</h1>
        <small
          >Published at {{ post.publicationDate.toLocaleDateString() }}
        </small>
      </div>
    </div>

    <div class="bg-white text-black">
      <div class="container mx-auto py-6">
        <div class="mb-12">
          <image-cache
            class="block mb-6"
            size="lg"
            :src="post.featuredImage"
          ></image-cache>
          <nuxt-link
            v-for="tag in post.tags.data"
            :key="tag.slug"
            :to="{ name: 'tag', params: { tag: tag.slug } }"
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
            ># {{ tag.name }}</nuxt-link
          >
        </div>
        <div class="wysiwyg-content" v-html="post.body"></div>
      </div>
    </div>

    <footer-cta slot="footer"></footer-cta>
  </page>
</template>

<script>
import FooterCta from '~/components/call-to-actions/FooterCta'

export default {
  name: 'PostPage',
  components: {
    FooterCta
  },
  async asyncData({ app, params }) {
    const post = await app.$cmsApi.getPost({
      slug: params.slug
    })
    return {
      post
    }
  }
}
</script>

<style></style>
