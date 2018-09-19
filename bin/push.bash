#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd ${DIR}/../

# These vars must be set in the dev environment for the project to be deployable.
ssh_remote=${AGATE_DEPLOY_REMOTE}
prod_dir=${AGATE_DEPLOY_DIR}

git push origin master && ssh ${ssh_remote} ${prod_dir}/bin/deploy.bash
