
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Deploy](deploy.md)

You can set up vhosts in different configuration.
Mostly it can run on Apache without any issue, but can also work on Nginx.

# Apache vhost

**Note:** Symfony's `.htaccess` file should be written in the vhost instead of in a `.htaccess` file for performances
reasons.

But if you like, you can uncomment the "Symfony conf" part in the virtual host and use the `.htaccess` file by renaming
the `web/.htaccess.dist` file.

The dist file contains comments about what it does, whereas the vhost does not, that's all.

```apache
<VirtualHost *:80>

    # Change domain names if needed
    ServerName esteren.dev
    ServerAlias api.esteren.dev
    ServerAlias maps.esteren.dev
    ServerAlias corahnrin.esteren.dev
    ServerAlias www.esteren.dev
    ServerAlias back.esteren.dev
    ServerAlias games.esteren.dev

    DocumentRoot /var/www/corahn_rin/web

    <Directory /var/www/corahn_rin/web>

        # Uncomment if using php with cgi
        #AddHandler php-cgi .php
        #Action php-cgi /php-fcgi/php56

        AllowOverride all
        Options Indexes FollowSymLinks MultiViews
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
    ErrorLog /var/www/corahn_rin/app/logs/apache_error.log
    CustomLog /var/www/corahn_rin/app/logs/apache_access.log combined

</VirtualHost>
```

# Nginx vhost

First you need to set up your php-fpm configuration and make it work.

[Check the reference](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html#nginx) on
Symfony documentation if you need.

**Note:** be sure that the `fastcgi_pass` points to the right socket.

**Important:** You must remove one `location` block of `DEV` or `PROD` depending on your environment.

```nginx
server {

    # Change domain names if needed
    server_name
        esteren.dev
        api.esteren.dev
        maps.esteren.dev
        corahnrin.esteren.dev
        www.esteren.dev
        back.esteren.dev
        games.esteren.dev
    ;

    root /var/www/corahn_rin/web;

    # Avoids getting 404 errors for missing map tiles.
    location ~ ^/maps_tiles {
        try_files $uri /maps_tiles/empty.jpg;
    }

    # DEV
    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app_dev.php$is_args$args;
    }
    location ~ ^/(app_dev|config)\.php(/|$) {

        # Check your fastcgi path depending on your environment
        fastcgi_pass unix:/var/run/php5-fpm.sock; # With FPM socket
        #fastcgi_pass 127.0.0.1:9000;             # With FastCGI / FPM classic

        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;

        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    # PROD
    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app.php$is_args$args;
    }
    location ~ ^/app\.php(/|$) {

        # Check your fastcgi path depending on your environment
        fastcgi_pass unix:/var/run/php5-fpm.sock; # With FPM socket
        #fastcgi_pass 127.0.0.1:9000;             # With FastCGI / FPM classic

        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;

        fastcgi_param  SCRIPT_FILENAME  $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/app.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }

    # Logs are added automatically to Symfony's log dir
    error_log /var/www/corahn_rin/app/logs/nginx_error.log;
    access_log /var/www/corahn_rin/app/logs/nginx_access.log;
}
```
