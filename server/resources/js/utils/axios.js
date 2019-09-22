import axios from 'axios'
import Vue from 'vue'

Vue.prototype.$bus = new Vue()

export function createAxios(app) {
  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

  let token = document.head.querySelector('meta[name="csrf-token"]')

  if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
  }

  axios.interceptors.response.use(
    (response) => {
      if (response.config.method !== 'get' && response.data.message) {
        app.$bvToast.toast(response.data.message, {
          variant: response.data.status || 'success',
          solid: true
        })
      }
      return response
    },
    (error) => {
      if (error instanceof String) {
        app.$bvToast.toast(error, {
          variant: 'danger',
          solid: true
        })
        return Promise.reject(error)
      }

      if (error.response) {
        switch (error.response.status) {
          case 400:
            app.$bvToast.toast(error.response.data.message, {
              variant: 'danger',
              solid: true
            })
            return Promise.reject(error)
          case 401:
            return window.location.reload()
          case 403:
            app.$bvToast.toast(app.$t('exceptions.unauthorized'), {
              variant: 'danger',
              solid: true
            })
            return Promise.reject(error)
          case 404:
            app.$bvToast.toast(app.$t('exceptions.not_found'), {
              variant: 'danger',
              solid: true
            })
            return Promise.reject(error)
          case 422:
            app.$bvToast.toast(app.$t('exceptions.validation_errors'), {
              variant: 'danger',
              solid: true
            })
            app.$bus.$emit('form-errors', error.response.data.errors)
            return Promise.reject(error)
        }
      }

      app.$bvToast.toast(app.$t('exceptions.general'), {
        variant: 'danger',
        solid: true
      })

      return Promise.reject(error)
    }
  )
}
