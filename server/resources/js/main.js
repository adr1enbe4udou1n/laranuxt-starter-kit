import Vue from 'vue'

import '../sass/main.scss'
import 'babel-polyfill'
import BootstrapVue from 'bootstrap-vue'
import vClickOutside from 'v-click-outside'

import { formatDecimal, formatPercent, formatCurrency } from './utils/numbers'

import VueI18n from 'vue-i18n'
import messages from './lang'

import { createRouter } from './router'
import { createStore } from './store'
import { createAxios } from './utils/axios'

// Global components import
import './components'

import { objectToFormData } from './utils/object-to-form-data'

import App from './App'
import axios from 'axios'
import swal from 'sweetalert2'

// Server-side settings
let jsonSettings = document.querySelector('[data-settings-selector="settings-json"]')
let settings = jsonSettings ? JSON.parse(jsonSettings.textContent) : {}

Vue.prototype.$app = settings
Vue.prototype.$app.objectToFormData = objectToFormData
Vue.prototype.$app.route = window.route
Vue.prototype.$app.formatDecimal = formatDecimal
Vue.prototype.$app.formatPercent = formatPercent
Vue.prototype.$app.formatCurrency = formatCurrency

Vue.prototype.$http = axios
Vue.prototype.$swal = swal

let applyProps = (source, target) => {
  Object.keys(source).forEach((key) => {
    if (key in target) {
      if (target[key] instanceof Object) {
        if (source[key] === null) {
          return
        }
        if (source[key] instanceof Object && !Array.isArray(source[key])) {
          return applyProps(source[key], target[key])
        }
      }
      target[key] = source[key]
    }
  })
}

Vue.prototype.$applyProps = applyProps

/**
 * Vue plugins
 */
Vue.use(VueI18n)
Vue.use(BootstrapVue)
Vue.use(vClickOutside)

/**
 * App initialisation
 */
export function createApp() {
  let locale = document.documentElement.lang

  const i18n = new VueI18n({
    locale,
    messages
  })

  Vue.prototype.$confirm = (action = i18n.t('buttons.delete')) =>
    swal.fire({
      title: i18n.t('labels.are_you_sure'),
      icon: 'warning',
      focusCancel: true,
      showCancelButton: true,
      cancelButtonText: i18n.t('buttons.cancel'),
      confirmButtonColor: '#dd4b39',
      confirmButtonText: action
    })

  const store = createStore(settings)
  const router = createRouter(settings, store, i18n)

  /**
   * Vue Init
   */
  const app = new Vue({
    router,
    store,
    i18n,
    render: (h) => h(App)
  })

  /**
   * Axios
   */
  createAxios(app)

  return { app, router, store }
}

if (document.getElementById('app') !== null) {
  const { app } = createApp()
  app.$mount('#app')
}
