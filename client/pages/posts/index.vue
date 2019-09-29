<template>
  <page>
    <header-cta slot="hero"></header-cta>

    <div class="bg-white text-black">
      <div class="container mx-auto py-6">
        <div class="flex flex-wrap mb-6 -mx-4">
          <div
            v-for="post in posts"
            :key="post.slug"
            class="flex w-full sm:w-1/2 lg:w-1/3 mb-8 px-4"
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
import HeaderCta from '~/components/call-to-actions/HeaderCta'
import PostCard from '~/components/PostCard'
import FooterCta from '~/components/call-to-actions/FooterCta'
import Pagination from '~/components/Pagination'

export default {
  name: 'BlogPage',
  components: {
    HeaderCta,
    PostCard,
    FooterCta,
    Pagination
  },
  async asyncData({ app, params, query }) {
    const request = {
      page: parseInt(query.page || 1, 10),
      perPage: 18
    }

    if (params.tag) {
      const tag = await app.$cmsApi.getTag({ slug: params.tag })
      request.tags = [tag.name]
    }

    const { data, meta } = await app.$cmsApi.getPosts(request)
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
