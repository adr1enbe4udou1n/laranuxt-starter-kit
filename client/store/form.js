export const state = () => ({
  errors: {}
})

export const mutations = {
  setErrors(state, errors) {
    state.errors = errors || {}
  },
  clearErrors(state) {
    state.errors = {}
  }
}

export const getters = {
  hasErrors: (state) => (name) => {
    return Object.prototype.hasOwnProperty.call(state.errors, name)
  },
  errorMessages: (state) => (name) => {
    return state.errors[name] || []
  }
}
