<template>
  <page>
    <div slot="hero">
      <div class="container mx-auto py-20 text-center">
        <h1 class="text-center text-4xl uppercase mb-3">{{ post.title }}</h1>
      </div>
    </div>

    <div class="bg-white text-gray-700">
      <div class="container mx-auto py-6">
        <div class="mb-12">
          <image-cache
            class="block mb-6"
            size="lg"
            :src="post.featuredImage"
          ></image-cache>
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
