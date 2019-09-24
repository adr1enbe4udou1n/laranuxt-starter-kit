<template>
  <div>
    <ul class="flex border rounded">
      <li
        v-for="pageNum in pages"
        :key="pageNum"
        :class="{ active: isActive(pageNum) }"
        class="item"
      >
        <span v-if="isActive(pageNum)">
          {{ pageNum }}
        </span>
        <nuxt-link
          v-else
          :to="linkGen(pageNum)"
          class="hover:text-white hover:bg-gray-500"
        >
          {{ pageNum }}
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
