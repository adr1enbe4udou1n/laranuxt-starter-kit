<template>
  <section class="bg-white border-b py-8">
    <div class="container mx-auto pt-4 pb-12">
      <h1
        class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800"
      >
        Title
      </h1>
      <div class="w-full mb-4">
        <div
          class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"
        ></div>
      </div>

      <div class="flex flex-wrap">
        <div
          v-for="(card, i) in cards"
          :key="i"
          class="card w-full md:w-1/3 p-6 flex flex-col flex-grow flex-shrink"
        >
          <div
            class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow"
          >
            <a href="#" class="flex flex-wrap no-underline hover:no-underline">
              <p class="w-full text-gray-600 text-xs md:text-sm px-6">
                xGETTING STARTED
              </p>
              <div class="w-full font-bold text-xl text-gray-800 px-6">
                {{ card.title }}
              </div>
              <p class="text-gray-800 text-base px-6 mb-5">
                {{ card.content }}
              </p>
            </a>
          </div>
          <div
            class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6"
          >
            <div class="cta flex items-center">
              <button
                class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg"
              >
                Action
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
      cards: [
        {
          title: 'Lorem ipsum dolor sit amet.',
          content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo posuere et sit amet ligula.'
        },
        {
          title: 'Lorem ipsum dolor sit amet.',
          content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo posuere et sit amet ligula.'
        },
        {
          title: 'Lorem ipsum dolor sit amet.',
          content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo posuere et sit amet ligula.'
        }
      ]
    }
  }
}
</script>

<style scoped>
.card {
  &:nth-child(1) {
    & .cta {
      @apply justify-start;
    }
  }
  &:nth-child(2) {
    & .cta {
      @apply justify-center;
    }
  }
  &:nth-child(3) {
    & .cta {
      @apply justify-end;
    }
  }
}
</style>
