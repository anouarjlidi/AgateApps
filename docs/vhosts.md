
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

# Apache vhost

**Note:** Symfony's `.htaccess` file has been removed because it should be written in the vhost instead for
performances reasons.

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

    DocumentRoot /var/www/corahn_rin/public

    <Directory /var/www/corahn_rin/public>

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
        # Put it in the vhost for maximum performance.
        # > https://github.com/symfony/symfony-standard/blob/2.8/web/.htaccess
        DirectoryIndex index.php
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
            RewriteRule ^index\.php(/(.*)|$) %{ENV:BASE}/$2 [R=302,L]

            RewriteCond %{REQUEST_FILENAME} -f
            RewriteRule .? - [L]

            # Avoids getting 404 errors for missing map tiles.
            RewriteCond %{REQUEST_URI} maps_tiles/ [NC]
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule .? %{ENV:BASE}/maps_tiles/empty.jpg [L,R=302]

            RewriteRule .? %{ENV:BASE}/index.php [L]
        </IfModule>
        <IfModule !mod_rewrite.c>
            <IfModule mod_alias.c>
                RedirectMatch 302 ^/$ /index.php/
            </IfModule>
        </IfModule>

        ##### end symfony conf
        ########################

    </Directory>

    # Logs are added automatically to Symfony's log dir.
    ErrorLog /var/www/corahn_rin/var/log/apache_error.log
    CustomLog /var/www/corahn_rin/var/log/apache_access.log combined

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
    root /var/www/corahn_rin/public;
    
    # Security headers.
    add_header X-Xss-Protection "1; mode=block";
    add_header X-Content-Type-options "no sniff";
    add_header X-Frame-Options "SAMEORIGIN";
    add_header Strict-Transport-Security "max-age=31536000; includeSubdomains; preload";

    # Redirects HTTP to HTTPS.
    # You can safely remove this in development.
    # if ($scheme = http) {
    #     return 301 https://$http_host$request_uri;
    # }

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

    # Redirect everything to Heroku.
    # In development, replace this with your php-fpm/php-cgi proxy.
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

    # Heroku needs to use stderr, but in dev you can switch to a log file.
    error_log /var/www/corahn_rin/var/logs/nginx_error.log;
    access_log /var/www/corahn_rin/var/logs/nginx_access.log;
}
```
