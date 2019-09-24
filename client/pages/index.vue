<template>
  <page>
    <header-cta slot="hero"></header-cta>

    <block-home-1></block-home-1>
    <block-home-2></block-home-2>
    <block-pricing></block-pricing>

    <footer-cta slot="footer"></footer-cta>
  </page>
</template>

<script>
import HeaderCta from '~/components/call-to-actions/HeaderCta'
import BlockHome1 from '~/components/blocks/BlockHome1'
import BlockHome2 from '~/components/blocks/BlockHome2'
import BlockPricing from '~/components/blocks/BlockPricing'
import FooterCta from '~/components/call-to-actions/FooterCta'

export default {
  name: 'HomePage',
  components: {
    HeaderCta,
    BlockHome1,
    BlockHome2,
    BlockPricing,
    FooterCta
  }
}
</script>
