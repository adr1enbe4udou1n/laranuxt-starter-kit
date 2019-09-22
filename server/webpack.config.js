const Encore = require('@symfony/webpack-encore')

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')
  .cleanupOutputBeforeBuild()
  .enablePostCssLoader()
  .enableSassLoader()
  .enableVueLoader()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .addEntry('js/app', './resources/js/main.js')
  .addAliases({
    '@': `${__dirname}/resources/js/`,
    vue$: 'vue/dist/vue.runtime.esm.js',
    sweetalert2$: 'sweetalert2/dist/sweetalert2.js'
  })
  .disableSingleRuntimeChunk()
  .enableBuildNotifications()

if (Encore.isDevServer()) {
  Encore.disableCssExtraction()
}

module.exports = Encore.getWebpackConfig()
