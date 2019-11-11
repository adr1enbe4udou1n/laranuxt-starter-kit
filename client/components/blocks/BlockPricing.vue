<template>
  <section class="bg-gray-100 py-8">
    <div class="container mx-auto px-2 pt-4 pb-12 text-gray-800">
      <h1
        class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800"
      >
        Pricing
      </h1>
      <div class="w-full mb-4">
        <div
          class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"
        ></div>
      </div>

      <div class="flex flex-col sm:flex-row justify-center pt-12 my-12 sm:my-4">
        <div
          v-for="(price, i) in prices"
          :key="i"
          :class="{ active: price.recommended }"
          class="price flex flex-col w-5/6 mx-auto lg:mx-0 bg-white mt-4"
        >
          <div
            class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow"
          >
            <div class="title p-8 text-3xl font-bold text-center">
              {{ price.title }}
            </div>
            <div
              v-if="price.recommended"
              class="h-1 w-full gradient my-0 py-0 rounded-t"
            ></div>
            <ul class="features w-full text-center">
              <li
                v-for="(feature, j) in price.features"
                :key="j"
                class="border-b py-4"
              >
                {{ feature }}
              </li>
            </ul>
          </div>
          <div
            class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6"
          >
            <div class="amount w-full pt-6 font-bold text-center">
              £{{ price.amount }} <span class="text-base">per user</span>
            </div>
            <div class="flex items-center justify-center">
              <button
                class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg"
              >
                Sign Up
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      prices: [
        {
          slug: 'free',
          title: 'Free',
          recommended: false,
          features: ['Thing', 'Thing', 'Thing'],
          amount: 0
        },
        {
          slug: 'basic',
          title: 'Basic',
          recommended: true,
          features: ['Thing', 'Thing', 'Thing', 'Thing'],
          amount: 20
        },
        {
          slug: 'pro',
          title: 'Pro',
          recommended: false,
          features: ['Thing', 'Thing', 'Thing'],
          amount: 100
        }
      ]
    }
  }
}
</script>

<style scoped>
.price {
  &.active {
    @apply rounded-lg shadow-lg z-10;

    & .amount {
      @apply text-4xl;
    }

    & .features {
      @apply font-bold;
    }

    @screen lg {
      @apply w-1/3 shadow-lg z-10;
    }

    @screen sm {
      @apply -mt-6;
    }
  }

  &:not(.active) {
    @apply rounded-none text-gray-600;

    & .amount {
      @apply text-3xl;
    }

    & .features {
      @apply text-sm;
    }

    & .title {
      @apply border-b-4;
    }

    @screen lg {
      @apply w-1/4 rounded-l-lg;
    }
  }
}
</style>
