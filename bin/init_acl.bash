#!/bin/bash

# Init acl for files
setfacl -R \
    -m u:www-data:rwX \
    -m u:`whoami`:rwX \
    ../var \
    ../web/uploads

# Init acl for directories
setfacl -dR \
    -m u:www-data:rwX \
    -m u:`whoami`:rwX \
    ../var \
    ../web/uploads

