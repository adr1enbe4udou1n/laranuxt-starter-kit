import Vue from 'vue'
import Page from '~/components/Page'
import ImageCache from '~/components/ImageCache'
import FormInvalidFeedback from '~/components/FormInvalidFeedback'

Vue.component('page', Page)
Vue.component('image-cache', ImageCache)
Vue.component('form-invalid-feedback', FormInvalidFeedback)

export default ({ store }) => {
  Vue.directive('validate', (el, binding) => {
    el.classList.toggle(
      'invalid',
      store.getters['form/hasErrors'](binding.value)
    )
  })
}
