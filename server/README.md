<p align="center">
<a href="https://laravel.com/" target="_blank">
<img align="center" height="120" src="https://cdn.worldvectorlogo.com/logos/laravel-2.svg"/>
</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://swagger.io/" target="_blank">
<img align="center" height="120" src="https://seeklogo.com/images/S/swagger-logo-A49F73BAF4-seeklogo.com.png"/>
</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://coreui.io/vue/" target="_blank">
<img align="center" height="140" src="https://avatars1.githubusercontent.com/u/36859861"/>
</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://bootstrap-vue.js.org/" target="_blank">
<img align="center" height="120" src="https://raw.githubusercontent.com/bootstrap-vue/bootstrap-vue/dev/static/logo.png">
</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>

# Laravel API Starter Kit

> Server-side API Starter Kit used for data consumption (see client sample [here](../client/README.md)). It includes a full custom SPA BO based on Vue CoreUI (Bootstrap 4).

## Features

* User and roles management,
* Impersonation feature,
* Submissions management,
* Posts and pages management for frontend blog
* Rich seeders content.

### Laravel

* Based on the last [Laravel 6](https://laravel.com/),
* [Spatie Image](https://github.com/spatie/image) for on-fly optimized images via proxy.
* [Google Recaptcha](https://github.com/google/recaptcha) for server-side captcha.
* [Clockwork](https://github.com/itsgoingd/clockwork) for easy api debugging.

### Data

* [Spatie Translatable](https://github.com/spatie/laravel-translatable) for model multilanguage support,
* [Spatie Sortable](https://github.com/spatie/eloquent-sortable) for sortable model.
* [Spatie Laravel Tags](https://github.com/spatie/laravel-tags) for tags model support.
* [Spatie Enum](https://github.com/spatie/enum) for enums support.
* [Spatie Medialibrary](https://github.com/spatie/laravel-medialibrary) for centralized media table management.

### API

* [Laravel CORS](https://github.com/barryvdh/laravel-cors) for cors,
* [Spatie Fractal](https://github.com/spatie/laravel-fractal) for specific api data transform,
* [Swagger UI](https://github.com/darkaonline/l5-swagger) for api documentation generation.

### BO

* Full SPA based on [Vue CoreUI](https://github.com/coreui/coreui-free-vue-admin-template) and [Bootstrap-Vue](https://bootstrap-vue.js.org) template,
* Many useful plugins ([SweetAlert2](https://limonte.github.io/sweetalert2/), [Flatpickr](https://chmln.github.io/flatpickr/), CKEditor 4, etc.),
* Excel Export (thanks to [Maatwebsite](https://github.com/Maatwebsite/Laravel-Excel)) & Batch actions integrated within DataTables,
* [CKeditor 4](https://ckeditor.com/ckeditor-4/) configured only with the mostly common used features (autogrow, embed, horizontalrule, image2 plugins)
* [Elfinder](barryvdh/laravel-elfinder) for files management, integrated within Ckeditor 4,
* [Ziggy](https://github.com/tightenco/ziggy) for client-side route naming.

### Assets building, linters & code styling

* [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) for automatically fix PHP CS issues,
* [Webpack Encore](https://github.com/symfony/webpack-encore) for assets building,
* [Vue ESLint Plugin](https://github.com/vuejs/eslint-plugin-vue)
* [Prettier](https://github.com/prettier/prettier) for opinionated code formatter.

## Build Setup

### Requirements

* PHP 7.3
* MySQL 5.7 with JSON support or PostgreSQL

### For Local/Development

Server Backend :

``` bash
# install dependencies
$ composer install

# copy .env.example & configure environnement variables

# generate key
$ php artisan key:generate

# set storage link symlink
$ php artisan storage:link

# publish elfinder assets
$ php artisan elfinder:publish

# migrate & seed data
$ php artisan migrate [--seed]

# start dev server at localhost:8000
$ php artisan serve

# API Swagger documentation can be accessed and tested at http://localhost:8000/api/documentation
# Look at samples on dedicated API controllers (app/Api/Controllers) for enpoints and transformers (app/Transformers) for models in order to know how to build it
```

BO UI building :

``` bash
# install dependencies
yarn

# compiling BO assets with HMR support
yarn dev-server --port 9000

# BO is accessible by default at http://localhost:8000/admin, but path can be customized via APP_ADMIN_PATH environment variable
```

### Deploy

> See [global README](/#deploy)

### Code styling

PHP-CS-Fixer & ESLint+Prettier are used for style guidelines for both server and client side code.

PHP is pre-configured for official Laravel styling, just launch `./vendor/bin/php-cs-fixer fix` for global project auto-formatting.

JS use [Prettier Standard Style](https://github.com/prettier/prettier/) & eslint-loader is used within webpack for dynamic code styling recommendations.  
Moreover, [Official ESLint plugin for Vue.js](https://github.com/vuejs/eslint-plugin-vue) is included for heavy consistent code through all components vue files.

## License

This project is open-sourced software licensed under the [MIT license](https://adr1enbe4udou1n.mit-license.org).
