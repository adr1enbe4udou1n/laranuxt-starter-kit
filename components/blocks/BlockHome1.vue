<template>
  <section class="bg-white border-b py-8">
    <div class="container max-w-5xl mx-auto m-8">
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

      <div v-for="(card, i) in cards" :key="i" class="card flex flex-wrap">
        <div class="w-5/6 sm:w-1/2 p-6">
          <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
            {{ card.title }}
          </h3>
          <p class="text-gray-600 mb-8">
            {{ card.content }}
          </p>
        </div>
        <div class="w-full sm:w-1/2 p-6">
          <img :src="card.image" alt="" class="w-full sm:h-64 mx-auto" />
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
          title: 'Lorem ipsum dolor sit amet',
          content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo posuere et sit amet ligula.',
          image: '/img-1.svg'
        },
        {
          title: 'Lorem ipsum dolor sit amet',
          content:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo posuere et sit amet ligula.',
          image: '/img-2.svg'
        }
      ]
    }
  }
}
</script>

<style scoped>
.card:nth-child(even) {
  @apply flex-row-reverse;
}

.card:not(:last-child) {
  @apply mb-6;
}
</style>
