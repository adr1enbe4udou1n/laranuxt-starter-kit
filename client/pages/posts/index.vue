<template>
  <page>
    <div
      slot="hero"
      class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center"
    >
      <!--Left Col-->
      <div
        class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left"
      >
        <p class="uppercase tracking-loose w-full">
          What business are you?
        </p>
        <h1 class="my-4 text-5xl font-bold leading-tight">
          Main Hero Message to sell yourself!
        </h1>
        <p class="leading-normal text-2xl mb-8">
          Sub-hero message, not too long and not too short. Make it just right!
        </p>

        <button
          class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg"
        >
          Subscribe
        </button>
      </div>
      <!--Right Col-->
      <div class="w-full md:w-3/5 py-6 text-center">
        <img class="w-full md:w-4/5 z-50" src="hero.png" />
      </div>
    </div>

    <div class="bg-white text-black">
      <div class="container mx-auto py-6">
        <div class="flex flex-wrap mb-6">
          <div
            v-for="post in posts"
            :key="post.slug"
            class="w-full sm:w-1/2 lg:w-1/3 mb-4"
          >
            <PostCard :post="post"></PostCard>
          </div>
        </div>
        <div v-if="pages > 1" class="flex justify-center">
          <pagination
            :link-gen="linkGen"
            :pages="pages"
            :current-page="currentPage"
          ></pagination>
        </div>
      </div>
    </div>

    <footer-cta slot="footer"></footer-cta>
  </page>
</template>

<script>
import PostCard from '~/components/PostCard'
import FooterCta from '~/components/call-to-actions/FooterCta'
import Pagination from '~/components/Pagination'

export default {
  name: 'BlogPage',
  components: {
    PostCard,
    FooterCta,
    Pagination
  },
  async asyncData({ app, query }) {
    const { data, meta } = await app.$cmsApi.getPosts({
      page: parseInt(query.page || 1, 10),
      perPage: 18
    })
    return {
      posts: data,
      pages: meta.pagination.totalPages,
      currentPage: meta.pagination.currentPage
    }
  },
  methods: {
    linkGen(pageNum) {
      return {
        name: this.$route.name,
        query: pageNum === 1 ? {} : { page: pageNum }
      }
    }
  },
  watchQuery: ['page']
}
</script>
