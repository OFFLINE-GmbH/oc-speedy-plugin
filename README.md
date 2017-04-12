# oc-speedy-plugin
Website optimization plugin for October CMS

## Optimizations

Speedy provides you with the following optimization options. You can enable and disable them via the backend settings.

* HTTP/2 preloading
* Gzip
* Cache headers
* Domain sharding

## Requirements

Speedy currently only works with the Apache web server with enabled `htaccess` file support.

Speedy makes use of `mod_expires`, `mod_gzip` and `mod_headers`.