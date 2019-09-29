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
      <li v-if="showFirstDots" class="item">
        <span>...</span>
      </li>
      <li
        v-for="pageNum in numberOfLinks"
        :key="pageNum + startNumber - 1"
        :class="{ active: isActive(pageNum + startNumber - 1) }"
        class="item"
      >
        <nuxt-link
          :tag="getTag(pageNum + startNumber - 1)"
          :to="linkGen(pageNum + startNumber - 1)"
        >
          {{ pageNum + startNumber - 1 }}
        </nuxt-link>
      </li>
      <li v-if="showLastDots" class="item">
        <span>...</span>
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
    limit: {
      type: Number,
      default: 5
    },
    linkGen: {
      type: Function,
      default: () => () => {}
    }
  },
  data() {
    return {
      ellipsesThreshold: 3
    }
  },
  computed: {
    showAllPages() {
      return this.pages <= this.limit
    },
    nearFromBeginning() {
      return (
        !this.showAllPages &&
        (this.currentPage < this.limit - 1 &&
          this.limit > this.ellipsesThreshold)
      )
    },
    nearFromEnd() {
      return (
        !this.showAllPages &&
        !this.nearFromBeginning &&
        (this.pages - this.currentPage + 2 < this.limit &&
          this.limit > this.ellipsesThreshold)
      )
    },
    isOnTheMiddle() {
      return (
        !this.showAllPages &&
        !this.nearFromBeginning &&
        !this.nearFromEnd &&
        this.limit > this.ellipsesThreshold
      )
    },
    showFirstDots() {
      return this.nearFromEnd || this.isOnTheMiddle
    },
    showLastDots() {
      return this.nearFromBeginning || this.isOnTheMiddle
    },
    startNumber() {
      let startNumber = 1

      if (this.nearFromEnd) {
        startNumber = this.pages - this.numberOfLinks + 1
      } else if (this.isOnTheMiddle) {
        startNumber = this.currentPage - Math.floor(this.numberOfLinks / 2)
      }

      if (startNumber < 1) {
        return 1
      }

      if (startNumber > this.pages - this.numberOfLinks) {
        return this.pages - this.numberOfLinks + 1
      }
      return startNumber
    },
    numberOfLinks() {
      if (this.showAllPages) {
        return this.pages
      }
      if (this.nearFromBeginning || this.nearFromEnd) {
        return this.limit - 1
      }
      if (this.isOnTheMiddle) {
        return this.limit - 2
      }
      return this.limit
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
