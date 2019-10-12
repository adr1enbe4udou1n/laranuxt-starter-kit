import Vue from 'vue'
import Router from 'vue-router'

import HomePage from '~/pages/index'
import BlogPage from '~/pages/posts/index'
import PostPage from '~/pages/posts/_slug'
import Page from '~/pages/_slug'
import Contact from '~/pages/contact'

Vue.use(Router)

export function createRouter() {
  return new Router({
    mode: 'history',
    routes: [
      {
        path: '/',
        name: 'home',
        component: HomePage
      },
      {
        path: '/blog',
        name: 'blog',
        component: BlogPage
      },
      {
        path: '/blog/:slug',
        name: 'post',
        component: PostPage
      },
      {
        path: '/blog/tags/:tag',
        name: 'tag',
        component: BlogPage
      },
      {
        path: '/contact',
        name: 'contact',
        component: Contact
      },
      {
        path: '/:slug',
        name: 'page',
        component: Page
      }
    ]
  })
}
