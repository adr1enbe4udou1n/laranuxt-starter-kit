<template>
  <nav
    id="header"
    :class="{ 'nav-sticky': scrollY > 10 }"
    class="fixed w-full z-30 top-0 text-white"
  >
    <div
      class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2"
    >
      <div class="pl-4 flex items-center">
        <nuxt-link
          class="toggleColour uppercase text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
          to="/"
        >
          <!--Icon from: http://www.potlabicons.com/ -->
          <logo></logo>
          Company
        </nuxt-link>
      </div>

      <div class="block lg:hidden pr-4">
        <button
          id="nav-toggle"
          @click="openedNav = !openedNav"
          class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-800 hover:border-teal-500 appearance-none focus:outline-none"
        >
          <toggle></toggle>
        </button>
      </div>

      <div
        id="nav-content"
        :class="{ hidden: !openedNav }"
        class="w-full flex-grow lg:flex lg:items-center lg:w-auto lg:block mt-2 lg:mt-0 bg-white lg:bg-transparent text-black p-4 lg:p-0 z-20"
      >
        <ul class="list-reset lg:flex justify-end flex-1 items-center">
          <li v-for="(link, index) in links" :key="index" class="mr-3">
            <nuxt-link
              :to="link.to"
              class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4"
              >{{ link.title }}</nuxt-link
            >
          </li>
        </ul>
        <button
          id="nav-action"
          class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-4 px-8 shadow opacity-75"
        >
          Action
        </button>
      </div>
    </div>

    <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
  </nav>
</template>

<script>
import Logo from '~/components/Logo'
import Toggle from '~/components/Toggle'

export default {
  components: {
    Logo,
    Toggle
  },
  data() {
    return {
      openedNav: false,
      scrollY: 0,
      links: [
        {
          title: 'Official Blog',
          to: { name: 'blog' }
        },
        {
          title: 'About Us',
          to: '/about-us'
        },
        {
          title: 'Contact',
          to: '/contact'
        }
      ]
    }
  },
  beforeMount() {
    window.addEventListener('scroll', this.handleScroll)
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll)
  },
  methods: {
    handleScroll() {
      this.scrollY = window.scrollY
    }
  }
}
</script>

<style scoped>
#header.nav-sticky {
  @apply bg-white shadow;

  & #nav-content {
    @apply bg-white;
  }

  & #nav-action {
    @apply gradient text-white;
  }

  & .toggleColour {
    @apply text-gray-800;
  }
}

#header:not(.nav-sticky) {
  & #nav-action {
    @apply bg-white text-gray-800;
  }

  & .toggleColour {
    @apply text-white;
  }
}
</style>
