export function createCrudRoutes(i18n, entity, options = {}) {
  let children = []
  let optionsConfig = Object.assign(
    {
      directory: null,
      showRoute: `${entity}.show`,
      titleAttribute: 'title',
      routes: ['index', 'create', 'edit'],
      path: `/${entity}`,
      roles: []
    },
    options
  )

  let directory = optionsConfig.directory !== null ? `views/${optionsConfig.directory}` : 'views'

  if (optionsConfig.routes.includes('index')) {
    children.push({
      path: '/',
      name: `${entity}-index`,
      component: () => import(`@/${directory}/${entity}/Index`),
      meta: {
        label: i18n.t(`titles.${entity}.index`),
        roles: optionsConfig.roles
      }
    })
  }

  if (optionsConfig.routes.includes('create')) {
    children.push({
      path: 'create',
      name: `${entity}-create`,
      component: () => import(`@/${directory}/${entity}/Create`),
      meta: {
        label: i18n.t(`titles.${entity}.create`),
        roles: optionsConfig.roles
      }
    })
  }

  if (optionsConfig.routes.includes('edit')) {
    children.push({
      path: ':id/edit',
      name: `${entity}-edit`,
      component: () => import(`@/${directory}/${entity}/Edit`),
      props: true,
      meta: {
        labelModel: (model) =>
          i18n.t(`titles.${entity}.edit`, {
            title: model[optionsConfig.titleAttribute]
          }),
        showRoute: optionsConfig.showRoute,
        roles: optionsConfig.roles
      }
    })
  }

  return {
    path: optionsConfig.path,
    redirect: optionsConfig.path,
    name: entity,
    component: {
      render(c) {
        return c('router-view')
      }
    },
    meta: {
      label: i18n.t(`titles.${entity}.main`)
    },
    children
  }
}
