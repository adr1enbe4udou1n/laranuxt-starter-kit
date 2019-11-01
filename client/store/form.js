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
    return state.errors.hasOwnProperty(name)
  },
  errorMessages: (state) => (name) => {
    return state.errors[name] || []
  }
}
