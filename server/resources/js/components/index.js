import Vue from 'vue'

export function requireComponents(components) {
  components.keys().forEach((fileName) => {
    const componentConfig = components(fileName)

    Vue.component(
      fileName
        .replace(/^\.\/(.*)\.\w+$/, '$1')
        .split('/')
        .reverse()[0],
      componentConfig.default
    )
  })
}

const context = require.context('./', true, /[A-Z]\w+\.(vue|js)$/)

requireComponents(context)
