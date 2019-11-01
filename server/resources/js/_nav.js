export function createNav(router, i18n) {
  let navs = [
    {
      name: i18n.t('navs.dashboard'),
      url: '/dashboard',
      icon: 'fas fa-tachometer-alt'
    },
    {
      title: true,
      name: i18n.t('navs.content_management')
    }
  ]

  if (router.canAccess({ name: 'pages' })) {
    navs.push({
      name: i18n.t('navs.pages'),
      url: '/pages',
      icon: 'fas fa-columns'
    })
  }

  if (router.canAccess({ name: 'posts' })) {
    let children = [
      {
        name: i18n.t('navs.posts'),
        url: '/posts',
        icon: 'fas fa-newspaper'
      }
    ]

    if (router.canAccess({ name: 'tags' })) {
      children.push({
        name: i18n.t('navs.tags'),
        url: '/posts/tags',
        icon: 'fas fa-tags'
      })
    }

    navs.push({
      name: i18n.t('navs.blog'),
      icon: 'fas fa-blog',
      url: '/posts',
      children
    })

    if (router.canAccess({ name: 'submissions' })) {
      navs.push({
        name: i18n.t('navs.submissions'),
        url: '/submissions',
        icon: 'fas fa-list'
      })
    }
  }

  if (router.canAccess({ name: 'users' })) {
    navs.push(
      {
        title: true,
        name: i18n.t('navs.access_management')
      },
      {
        name: i18n.t('navs.users'),
        url: '/users',
        icon: 'fas fa-users'
      }
    )
  }
  return navs
}
