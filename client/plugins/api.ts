import { Plugin } from '@nuxt/types'
import { CmsApi, SubmissionApi, Configuration } from '~/openapi/src'

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
    $submissionApi: SubmissionApi
  }
}

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $cmsApi: CmsApi,
    $submissionApi: SubmissionApi
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    $cmsApi: CmsApi,
    $submissionApi: SubmissionApi
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
  const submissionApi = new SubmissionApi(config)
  inject('cmsApi', cmsApi)
  inject('submissionApi', submissionApi)
}

export default api
