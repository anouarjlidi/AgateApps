#!/bin/bash

# Get init_acl.bash directory name
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Get root project directory name
DIR=`readlink -m "${DIR}/../"`

# Change directory to root directory so all commands are executed from there
cd ${DIR} || exit 100

# Init acl for files
setfacl -R \
    -m u:www-data:rwX \
    -m u:`whoami`:rwX \
    ${DIR}/var \
    ${DIR}/web/uploads

# Init acl for directories
setfacl -dR \
    -m u:www-data:rwX \
    -m u:`whoami`:rwX \
    ${DIR}/var \
    ${DIR}/web/uploads
