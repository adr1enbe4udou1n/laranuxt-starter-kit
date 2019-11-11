<p align="center">
<a href="https://nuxtjs.org/" target="_blank">
<img align="center" height="120" src="https://fr.nuxtjs.org/logos/nuxt.svg"/></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<img align="center" height="60" src="https://image.flaticon.com/icons/svg/148/148836.svg"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://laravel.com/" target="_blank">
<img align="center" height="120" src="https://cdn.worldvectorlogo.com/logos/laravel-2.svg"/></a>
</p>

# LaraNuxt

> Minimal Blogger Starter Kit build with Nuxt as Frontend and Laravel as Backend API.

* Frontend demo : https://laranuxt.okami101.io
* Backend demo : https://laranuxt.okami101.io/admin (admin@example.com/password, read-only)

## [Build Setup](#setup)

* Server : [See dedicated README](server)
* Client : [See dedicated README](client)

## [Deploy](#deploy)

* Use [PM2](https://pm2.keymetrics.io/) to launch Nuxt server node on specific port. Example you can use this command `pm2 start npm --name "laranuxt" -- start -- --port 3000`,
* Use this [Git post-merge hook](post-merge.sh) for server & client building automation on each pull,
* Use this [Nginx template](nginx.conf).

## License

This project is open-sourced software licensed under the [MIT license](https://adr1enbe4udou1n.mit-license.org).
