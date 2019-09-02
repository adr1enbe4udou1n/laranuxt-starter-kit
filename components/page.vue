<template>
  <div>
    <template v-if="$slots.hero">
      <!--Hero-->
      <div class="pt-24">
        <slot name="hero"></slot>
      </div>

      <div class="relative -mt-12 lg:-mt-24">
        <header-waves></header-waves>
      </div>
    </template>

    <slot></slot>

    <template v-if="$slots.footer">
      <!-- Change the colour #f8fafc to match the previous section colour -->
      <footer-waves></footer-waves>

      <section class="container mx-auto text-center py-6 mb-12">
        <slot name="footer"></slot>
      </section>
    </template>
  </div>
</template>

<script>
import HeaderWaves from '~/components/HeaderWaves'
import FooterWaves from '~/components/FooterWaves'

export default {
  components: {
    HeaderWaves,
    FooterWaves
  }
}
</script>
