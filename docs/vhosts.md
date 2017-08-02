
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

You can set up vhosts in different configuration.
Mostly it can run on Apache without any issue, but can also work on Nginx.

# Web entry point

The `app_dev.php` file was removed and we only use `app.php` file in order to use environment vars for server parameters.

This allows better support for other kind of systems like Docker stack (which we hope we can use one day).

This is the reason why you need to set both `SYMFONY_ENV` and `SYMFONY_DEBUG` vars.

# Apache vhost

**Note:** Symfony's `.htaccess` file has been removed because it should be written in the vhost instead of in a
 `.htaccess` file for performances reasons.

The only difference is that the dist file contains comments about what it does, whereas the vhost does not, that's all.

```apache
<VirtualHost *:80>

    # Change domain names if needed
    ServerName            esteren.dev
    ServerAlias       www.esteren.dev
    ServerAlias       api.esteren.dev
    ServerAlias      maps.esteren.dev
    ServerAlias      back.esteren.dev
    ServerAlias     games.esteren.dev
    ServerAlias    portal.esteren.dev
    ServerAlias corahnrin.esteren.dev
    ServerAlias  www.studio-agate.dev
    ServerAlias   www.vermine2047.dev

    DocumentRoot /var/www/corahn_rin/web

    # Change env vars if needed
    SetEnv SYMFONY_ENV   dev
    SetEnv SYMFONY_DEBUG   1

    <Directory /var/www/corahn_rin/web>

        # Uncomment if using php with cgi
        #AddHandler php-cgi .php
        #Action php-cgi /php-fcgi/php56

        AllowOverride all
        Options Indexes FollowSymLinks MultiViews ExecCGI
        Require all granted

        ########################
        ##### start symfony conf

        # Here starts Symfony's .htaccess config.
        # Put it in the vhost for maximum performance.
        # For more info, check web/.htaccess.dist default file.
        # > https://github.com/symfony/symfony-standard/blob/2.8/web/.htaccess
        DirectoryIndex app.php
        <IfModule mod_negotiation.c>
            Options -MultiViews
        </IfModule>
        <IfModule mod_rewrite.c>
            RewriteEngine On

            RewriteCond %{REQUEST_URI}::$1 ^(/.+)/(.*)::\2$
            RewriteRule ^(.*) - [E=BASE:%1]

            RewriteCond %{HTTP:Authorization} .
            RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

            RewriteCond %{ENV:REDIRECT_STATUS} ^$
            RewriteRule ^app\.php(/(.*)|$) %{ENV:BASE}/$2 [R=302,L]

            RewriteCond %{REQUEST_FILENAME} -f
            RewriteRule .? - [L]

            # Avoids getting 404 errors for missing map tiles.
            RewriteCond %{REQUEST_URI} maps_tiles/ [NC]
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule .? %{ENV:BASE}/maps_tiles/empty.jpg [L,R=302]

            RewriteRule .? %{ENV:BASE}/app.php [L]
        </IfModule>
        <IfModule !mod_rewrite.c>
            <IfModule mod_alias.c>
                RedirectMatch 302 ^/$ /app.php/
            </IfModule>
        </IfModule>

        ##### end symfony conf
        ########################

    </Directory>

    # Logs are added automatically to Symfony's log dir
    ErrorLog /var/www/corahn_rin/var/logs/apache_error.log
    CustomLog /var/www/corahn_rin/var/logs/apache_access.log combined

</VirtualHost>
```

# Nginx vhost

First you need to set up your php-fpm configuration and make it work.

[Check the reference](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html#nginx) on
Symfony documentation if you need.

**Note:** be sure that the `fastcgi_pass` points to the right socket/host.

```nginx
server {

    # Change domain names if needed
    server_name
        www.studio-agate.dev
         www.vermine2047.dev
                 esteren.dev
             www.esteren.dev
             api.esteren.dev
            maps.esteren.dev
            back.esteren.dev
           games.esteren.dev
          portal.esteren.dev
       corahnrin.esteren.dev
    ;

    # Change the directory to what you need.
    # Also change logs dir at the bottom of this file.
    root /var/www/corahn_rin/web;

    # Change this part when using for prod
    env SYMFONY_ENV=dev;
    env SYMFONY_DEBUG=1;

    location ~ ^/(?:fr|en)/js/ {
        # For JS generated files, they should be processed by Symfony, not by nginx
        try_files $uri @rewriteapp;
    }

    # Uncomment this on production
    #location ~* \.(?:css|js|jpg|jpeg|gif|png|ico|svg)$ {
    #    if ($arg_assetv != '')  {
    #        expires 1y;
    #        access_log off;
    #        add_header Cache-Control "public";
    #    }
    #}

    # Avoids getting 404 errors for missing map tiles.
    location ~ ^/maps_tiles {
        try_files $uri /maps_tiles/empty.jpg;
    }

    location / {
        # try to serve file directly, fallback to rewrite
        try_files $uri @rewriteapp;
    }

    location @rewriteapp {
        # rewrite all to app.php
        rewrite ^(.*)$ /app.php/$1 last;
    }

    # Remove the "config" part in production
    location ~ ^/(app|config)\.php(/|$) {

        # Check your fastcgi path depending on your environment
        fastcgi_pass unix:/var/run/php5-fpm.sock; # With FPM socket
        #fastcgi_pass 127.0.0.1:9000;             # With FastCGI / FPM classic

        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;

        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
        return 404;
    }

    # Logs are added automatically to Symfony's log dir
    error_log /var/www/corahn_rin/var/logs/nginx_error.log;
    access_log /var/www/corahn_rin/var/logs/nginx_access.log;
}
```
