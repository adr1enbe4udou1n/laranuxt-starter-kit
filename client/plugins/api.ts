import { Plugin } from '@nuxt/types'
import { CmsApi, SubmissionsApi, Configuration } from '~/openapi'

declare global {
  namespace NodeJS {
    interface Global {
      FormData: any,
      URLSearchParams: any
    }
  }
}

declare module 'vue/types/vue' {
  interface Vue {
    $cmsApi: CmsApi,
    $submissionApi: SubmissionsApi
  }
}

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $cmsApi: CmsApi,
    $submissionApi: SubmissionsApi
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    $cmsApi: CmsApi,
    $submissionApi: SubmissionsApi
  }
}

const api: Plugin = (context, inject) => {
  const basePath = process.env.API_URL
  let config = new Configuration({ basePath, headers: { Accept: 'application/json' } })
  if (process.server) {
    global.FormData = require('form-data')
    global.URLSearchParams = require('url').URLSearchParams
    config = new Configuration({ fetchApi: fetch, basePath })
  }
  const cmsApi = new CmsApi(config)
  const submissionApi = new SubmissionsApi(config)
  inject('cmsApi', cmsApi)
  inject('submissionApi', submissionApi)
}

export default api
