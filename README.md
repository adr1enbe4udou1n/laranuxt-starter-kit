<p align="center">
<a href="https://nuxtjs.org/" target="_blank">
<img align="center" height="120" src="https://fr.nuxtjs.org/logos/nuxt.svg"/></a>
<a href="https://tailwindcss.com/" target="_blank">
<img align="center" height="30" src="https://seeklogo.com/images/T/tailwind-css-logo-5AD4175897-seeklogo.com.png"/></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img align="center" height="60" src="https://image.flaticon.com/icons/svg/148/148836.svg"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://laravel.com/" target="_blank">
<img align="center" height="120" src="https://cdn.worldvectorlogo.com/logos/laravel-2.svg"/></a>
<a href="https://coreui.io/vue/" target="_blank">
<img align="center" height="50" src="https://avatars1.githubusercontent.com/u/36859861"/></a>
</p>

# LaraNuxt

> Minimal Blogger Starter Kit build with Nuxt as Frontend and Laravel as Backend API.

* Frontend demo : https://laranuxt.okami101.io
* Backend demo : https://laranuxt.okami101.io/admin (admin@example.com/password, read-only)

## [Main features](features)

* [Nuxt starter kit](client) is based on [Tailwind CSS](https://tailwindcss.com/) for lightning fast frontend building,
* [Laravel starter kit](server) includes full custom SPA BO based on [Vue CoreUI](https://github.com/coreui/coreui-free-vue-admin-template).

## [Build Setup](#setup)

* Server : [See dedicated README](server#setup)
* Client : [See dedicated README](client#setup)

## [Deploy](#deploy)

* Use [PM2](https://pm2.keymetrics.io/) to launch Nuxt server node on specific port. Example you can use this command `pm2 start npm --name "laranuxt" -- start -- --port 3000`,
* Use this [Git post-merge hook](post-merge.sh) for server & client building automation on each pull,
* Use this [Nginx template](nginx.conf).

## License

This project is open-sourced software licensed under the [MIT license](https://adr1enbe4udou1n.mit-license.org).
