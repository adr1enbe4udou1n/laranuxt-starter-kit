<template>
  <footer class="bg-white">
    <div class="container mx-auto  px-8">
      <div class="w-full flex flex-col md:flex-row py-6">
        <div class="flex-1 mb-6">
          <a
            class="uppercase text-orange-600 no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
            href="#"
          >
            <!--Icon from: http://www.potlabicons.com/ -->
            <logo></logo>
            Company
          </a>
        </div>

        <div v-for="(item, i) in items" :key="i" class="flex-1">
          <p class="uppercase text-gray-500 md:mb-6">{{ item.title }}</p>
          <ul class="list-reset mb-6">
            <li
              v-for="(link, j) in item.links"
              :key="j"
              class="mt-2 inline-block mr-2 md:block md:mr-0"
            >
              <nuxt-link
                :to="link.to"
                :target="link.target || 'self'"
                class="no-underline hover:underline text-gray-800 hover:text-orange-500"
                >{{ link.title }}</nuxt-link
              >
            </li>
          </ul>
        </div>
      </div>
    </div>

    <a href="https://www.freepik.com/free-photos-vectors/background"
      >Background vector created by freepik - www.freepik.com</a
    >
  </footer>
</template>

<script>
import Logo from '@/components/logo'

export default {
  components: {
    Logo
  },
  data() {
    return {
      items: [
        {
          title: 'Links',
          links: [
            {
              title: 'FAQ',
              to: '/faq'
            },
            {
              title: 'Help',
              to: '/help'
            },
            {
              title: 'Support',
              to: '/support'
            }
          ]
        },
        {
          title: 'Legal',
          links: [
            {
              title: 'Terms',
              to: '/terms'
            },
            {
              title: 'Privacy',
              to: '/privacy'
            }
          ]
        },
        {
          title: 'Social',
          links: [
            {
              title: 'Facebook',
              to: '//www.facebook.com',
              target: '_blank'
            },
            {
              title: 'Linkedin',
              to: '//www.linkedin.com',
              target: '_blank'
            },
            {
              title: 'Twitter',
              to: '//www.twitter.com',
              target: '_blank'
            }
          ]
        },
        {
          title: 'Company',
          links: [
            {
              title: 'Official Blog',
              to: '/blog'
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
      ]
    }
  }
}
</script>
