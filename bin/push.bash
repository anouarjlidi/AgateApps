#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd ${DIR}/../

ssh_remote=agate
prod_dir=/var/www/www.studio-agate.com/www

git push origin master \
 && ssh ${ssh_remote} git -C ${prod_dir} pull origin master \
 && ssh ${ssh_remote} ${prod_dir}/bin/deploy.bash
