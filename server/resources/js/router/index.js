import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios'

import { createRoutes } from './routes'

Vue.use(Router)

export function createRouter(app, store, i18n) {
  const router = new Router({
    mode: 'history',
    base: app.admin_path,
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes: createRoutes(i18n)
  })

  /**
   * Gestion des accès par route selon les rôles de l'utilisateur courant
   *
   * @param to
   * @returns {boolean|number}
   */
  router.canAccess = (to) => {
    let { route } = router.resolve(to)
    let roles = route.meta.roles || []
    if (!roles.length) {
      return true
    }
    if (store.state.user) {
      if (store.state.user.id === 1) {
        // Utilisateur super admin
        return true
      }
      // Intersaction des rôles pour vérifier l'accès
      return roles.filter((role) => (store.state.user.roles || []).includes(role)).length
    }
    return false
  }

  router.beforeEach(async (to, from, next) => {
    // access management
    if (!to.name || !router.canAccess(to)) {
      return next('/')
    }

    if (to.meta.showRoute) {
      let { data } = await axios.get(
        app.route(to.meta.showRoute, {
          id: to.params.id
        })
      )

      to.meta.model = data

      to.meta.label = to.meta.labelModel(data)
    }

    // Meta title
    document.title = `${to.meta.label} | ${app.name}`

    // Body class
    if (from.name) {
      document.body.classList.remove(`page-${from.name.replace(/_/g, '-')}`)
    }
    document.body.classList.add(`page-${to.name.replace(/_/g, '-')}`)

    next()
  })

  return router
}
