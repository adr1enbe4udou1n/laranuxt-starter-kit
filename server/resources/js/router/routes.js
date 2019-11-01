// Containers
import DefaultContainer from '@/containers/DefaultContainer'

// Views
import Dashboard from '@/views/Dashboard'
import Profile from '@/views/Profile'

import { createCrudRoutes } from './entity-crud-routes'

export function createRoutes(i18n) {
  return [
    {
      path: '/',
      redirect: '/dashboard',
      name: 'home',
      component: DefaultContainer,
      meta: {
        label: i18n.t('titles.home')
      },
      children: [
        {
          path: 'dashboard',
          name: 'dashboard',
          component: Dashboard,
          meta: {
            label: i18n.t('titles.dashboard')
          }
        },
        {
          path: 'profile',
          name: 'profile',
          component: Profile,
          meta: {
            label: i18n.t('titles.profile')
          }
        },
        createCrudRoutes(i18n, 'users', { titleAttribute: 'name', roles: ['admin'] }),
        createCrudRoutes(i18n, 'pages', { directory: 'content', showRoute: 'posts.show', roles: ['admin', 'editor'] }),
        createCrudRoutes(i18n, 'posts', { directory: 'content', roles: ['admin', 'editor'] }),
        createCrudRoutes(i18n, 'submissions', { directory: 'content', roles: ['admin', 'editor'] }),
        createCrudRoutes(i18n, 'tags', {
          directory: 'content',
          titleAttribute: 'name',
          routes: ['index'],
          path: '/posts/tags',
          roles: ['admin', 'editor']
        })
      ]
    }
  ]
}
