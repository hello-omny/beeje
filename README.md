#### Install dependencies

`$ composer install`

#### Configure nginx

Something like this:

```
server {
    charset utf-8;

    listen 80;

    server_name beejee.local;

    root        /www/test-projects/beejee/web;
    index       index.php;

    access_log  /www/test-projects/beejee/log/beejee.local.access.log;
    error_log   /www/test-projects/beejee/log/beejee.local.error.log;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass 127.0.0.1:9000;
        try_files $uri =404;
    }

    location ~* /\. {
        deny all;
    }
}
```

Reload nginx and try it on `http://beejee.local/` and admin area `http://beejee.local/admin`. From the box it used sql_light driver and pre loaded db scheme.

#### Using mysql driver

If using mysql driver, plz, create db scheme to it.

`$ vendor/bin/doctrine orm:schema-tool:update --force`
