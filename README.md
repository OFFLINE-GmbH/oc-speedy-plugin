# Speedy plugin
Website optimization plugin for October CMS.

## Optimizations

Speedy provides you with the following optimization options. You can enable and disable them via the backend settings.

* HTTP/2 preloading
* Gzip
* Cache headers
* Domain sharding

## Requirements

Speedy currently only works with the Apache web server with enabled `htaccess` file support.

Speedy makes use of `mod_expires`, `mod_gzip` and `mod_headers`.

## Attributions

The speedy flash icon was created by [SagarUnagar](https://www.iconfinder.com/SagarUnagar) and is licensed under [CC BY 3.0](https://creativecommons.org/licenses/by/3.0/). Speedy uses a modified version of [JacobBennett's laravel-HTTP2ServerPush](https://github.com/JacobBennett/laravel-HTTP2ServerPush) middleware which is licensed under the [MIT license](https://github.com/JacobBennett/laravel-HTTP2ServerPush/blob/master/LICENSE.md).
