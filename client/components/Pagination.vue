<template>
  <div>
    <ul class="flex border rounded">
      <li class="item">
        <nuxt-link :tag="getTag(1)" :to="linkGen(1)">
          «
        </nuxt-link>
      </li>
      <li class="item">
        <nuxt-link :tag="getTag(1)" :to="linkGen(currentPage - 1)">
          ‹
        </nuxt-link>
      </li>
      <li
        v-for="pageNum in pages"
        :key="pageNum"
        :class="{ active: isActive(pageNum) }"
        class="item"
      >
        <nuxt-link :tag="getTag(pageNum)" :to="linkGen(pageNum)">
          {{ pageNum }}
        </nuxt-link>
      </li>
      <li class="item">
        <nuxt-link :tag="getTag(pages)" :to="linkGen(currentPage + 1)">
          ›
        </nuxt-link>
      </li>
      <li class="item">
        <nuxt-link :tag="getTag(pages)" :to="linkGen(pages)">
          »
        </nuxt-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    pages: {
      type: Number,
      default: 1
    },
    currentPage: {
      type: Number,
      default: 1
    },
    linkGen: {
      type: Function,
      default: () => () => {}
    }
  },
  methods: {
    isActive(pageNum) {
      return this.currentPage === pageNum
    },
    getTag(pageNum) {
      return this.isActive(pageNum) ? 'span' : 'a'
    }
  }
}
</script>

<style scoped>
.item {
  & a,
  & span {
    @apply block w-10 text-center border-r py-2;
  }

  & a:hover {
    @apply text-white bg-gray-500;
  }

  &:first-child {
    & a,
    & span {
      @apply rounded-l;
    }
  }

  &:last-child {
    & a,
    & span {
      @apply border-r-0 rounded-r;
    }
  }

  &.active {
    & a,
    & span {
      @apply text-white bg-black;
    }
  }
}
</style>
