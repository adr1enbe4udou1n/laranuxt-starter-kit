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

    <block-home-1></block-home-1>
    <block-home-2></block-home-2>
    <block-pricing></block-pricing>

    <div slot="footer">
      <h1
        class="w-full my-2 text-5xl font-bold leading-tight text-center text-white"
      >
        Call to Action
      </h1>
      <div class="w-full mb-4">
        <div
          class="h-1 mx-auto bg-white w-1/6 opacity-25 my-0 py-0 rounded-t"
        ></div>
      </div>

      <h3 class="my-4 text-3xl leading-tight">
        Main Hero Message to sell yourself!
      </h3>

      <button
        class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg"
      >
        Action!
      </button>
    </div>
  </page>
</template>

<script>
import BlockHome1 from '~/components/blocks/BlockHome1'
import BlockHome2 from '~/components/blocks/BlockHome2'
import BlockPricing from '~/components/blocks/BlockPricing'

export default {
  name: 'Home',
  components: {
    BlockHome1,
    BlockHome2,
    BlockPricing
  }
}
</script>
