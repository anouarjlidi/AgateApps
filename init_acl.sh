#!/bin/sh
setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs web/uploads
setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs web/uploads
