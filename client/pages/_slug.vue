<template>
  <page>
    <div slot="hero">
      <div class="container py-20 text-center">
        <h1 class="text-center text-4xl uppercase mb-3">{{ post.title }}</h1>
      </div>
    </div>

    <div class="bg-white text-gray-700">
      <div class="container py-6">
        <div class="mb-12">
          <image-cache
            :src="post.featuredImage"
            class="block mb-6"
            size="lg"
          ></image-cache>
        </div>
        <div v-html="post.body" class="wysiwyg-content"></div>
      </div>
    </div>

    <footer-cta slot="footer"></footer-cta>
  </page>
</template>

<script>
import FooterCta from '~/components/call-to-actions/FooterCta'

export default {
  name: 'ContentPage',
  components: {
    FooterCta
  },
  async asyncData({ app, params }) {
    const post = await app.$cmsApi.getPage({
      slug: params.slug
    })
    return {
      post
    }
  }
}
</script>
