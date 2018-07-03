
#### Documentation index

* **[README](../README.md)**
* [Routing](routing.md)
* [General technical informations](technical.md)
* Set up a vhost
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

**⚠️ Use this ONLY when you cannot set up the project with Docker.**

You can set up vhosts in different configuration.

The project should work in both Apache and Nginx.

* [Apache vhost](#apache-vhost)
* [Nginx vhost](#nginx-vhost)

# Apache vhost

**Note:** Symfony's `.htaccess` file has been removed because it should be written in the vhost instead for
performances reasons.

```apache
<VirtualHost *:80>

    # Change domain names if needed
    ServerName        www.esteren.docker
    ServerAlias       api.esteren.docker
    ServerAlias      maps.esteren.docker
    ServerAlias      back.esteren.docker
    ServerAlias     games.esteren.docker
    ServerAlias    portal.esteren.docker
    ServerAlias corahnrin.esteren.docker
    ServerAlias  www.studio-agate.docker
    ServerAlias   www.vermine2047.docker

    DocumentRoot /var/www/agate_apps/public

    ErrorLog /var/www/agate_apps/var/log/apache_error.log
    CustomLog /var/www/agate_apps/var/log/apache_access.log combined

    <Directory /var/www/agate_apps/public>

        # Uncomment if using php with fastcgi or php-fpm.
        #<Files ~ "\.(php|phtml)$">
        #    SetHandler "proxy:fcgi://127.0.0.1:9000#"
        #</Files>

        AllowOverride all
        Options Indexes FollowSymLinks MultiViews ExecCGI
        Require all granted

        ########################
        ##### start symfony conf

        # Here starts Symfony's .htaccess config.
        # Comments were ripped off this file, so check the original one if you need to know how it works:
        # > https://github.com/symfony/recipes-contrib/blob/master/symfony/apache-pack/1.0/public/.htaccess
        DirectoryIndex index.php
        <IfModule mod_negotiation.c>
            Options -MultiViews
        </IfModule>
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_URI}::$1 ^(/.+)/(.*)::\2$
            RewriteRule ^(.*) - [E=BASE:%1]

            RewriteCond %{HTTP:Authorization} .
            RewriteRule ^ - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

            RewriteCond %{ENV:REDIRECT_STATUS} ^$
            RewriteRule ^index\.php(?:/(.*)|$) %{ENV:BASE}/$1 [R=301,L]

            RewriteCond %{REQUEST_FILENAME} -f
            RewriteRule ^ - [L]

            # Avoids getting 404 errors for missing map tiles.
            RewriteCond %{REQUEST_URI} maps_tiles/ [NC]
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule .? %{ENV:BASE}/maps_tiles/empty.jpg [L,R=302]

            RewriteRule ^ %{ENV:BASE}/index.php [L]
        </IfModule>
        <IfModule !mod_rewrite.c>
            <IfModule mod_alias.c>
                RedirectMatch 307 ^/$ /index.php/
            </IfModule>
        </IfModule>

        ##### end symfony conf
        ########################

    </Directory>

</VirtualHost>
```

# Nginx vhost

First you need to set up your php-fpm configuration and make it work.

[Check the reference](http://symfony.com/doc/current/setup/web_server_configuration.html#nginx) on
Symfony documentation if you need.

**Note:** be sure that the `fastcgi_pass` points to the right socket/host.

```nginx
server {

    # Change domain names if needed
    server_name
        www.studio-agate.docker
         www.vermine2047.docker
                 esteren.docker
             www.esteren.docker
             api.esteren.docker
            maps.esteren.docker
            back.esteren.docker
           games.esteren.docker
          portal.esteren.docker
       corahnrin.esteren.docker
    ;

    # Change the directory to what you need.
    # Also change logs dir at the bottom of this file.
    root /var/www/agate_apps/public;

    error_log /var/www/agate_apps/var/logs/nginx_error.log;
    access_log /var/www/agate_apps/var/logs/nginx_access.log;
    
    # Security headers.
    add_header X-Xss-Protection "1; mode=block";
    add_header X-Content-Type-options "no sniff";
    add_header X-Frame-Options "SAMEORIGIN";
    add_header Strict-Transport-Security "max-age=31536000; includeSubdomains; preload";

    # Avoids getting 404 errors for missing map tiles.
    location ~ ^/maps_tiles {
        try_files $uri @rewritemaptiles;
    }

    # Rewrite all to index.php
    location @rewritemaptiles {
        rewrite ^(.*)$ /maps_tiles/empty.jpg last;
    }

    # Caches assets
    # You can disable this in development if you encounter cache issues with assets.
    # location ~* \.(?:css|js|jpg|jpeg|gif|png|ico|eot|ttf|woff2?|svg) {
    #     if ($args ~ "assetv=")  {
    #         expires 1y;
    #         access_log off;
    #         add_header Cache-Control "public" always;
    #     }
    # }

    # Try to serve file directly, fallback to rewrite.
    location / {
        try_files $uri @rewriteapp;
    }

    # Rewrite all to index.php. This will trigger next location.
    location @rewriteapp {
        rewrite ^(.*)$ /index.php/$1 last;
    }

    # Redirect everything else to the php-fpm/php-cgi proxy
    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php7.1-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        internal;
    }

    # Return 404 for all other php files not matching the front controller.
    # This prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
        return 404;
    }
}
```
