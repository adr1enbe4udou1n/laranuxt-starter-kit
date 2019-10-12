import { Plugin } from '@nuxt/types'
import { CmsApi, ContactApi, Configuration } from '~/openapi/src'

declare global {
  namespace NodeJS {
    interface Global {
      FormData: any
    }
  }
}

declare module 'vue/types/vue' {
  interface Vue {
    $cmsApi: CmsApi,
    $contactApi: ContactApi
  }
}

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $cmsApi: CmsApi,
    $contactApi: ContactApi
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    $cmsApi: CmsApi,
    $contactApi: ContactApi
  }
}

const api: Plugin = (context, inject) => {
  const basePath = process.env.API_URL
  let config = new Configuration({ basePath, headers: { Accept: 'application/json' } })
  if (process.server) {
    global.FormData = require('form-data')
    config = new Configuration({ fetchApi: fetch, basePath })
  }
  const cmsApi = new CmsApi(config)
  const contactApi = new ContactApi(config)
  inject('cmsApi', cmsApi)
  inject('contactApi', contactApi)
}

export default api
