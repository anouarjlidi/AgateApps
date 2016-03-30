#!/bin/bash
setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX var web/uploads
setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var web/uploads

