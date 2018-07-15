
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* Deploy

# Deploy the project

The project is deployed via an ssh connection to the prod server, and you need the necessary credentials.

The `bin/push` (for Linux) and `bin/push.cmd` (for Windows) are here to trigger the deploy.

These are the deployment steps that are executed by the scripts:

* First, a simple `git push origin master` will be done on the repo, to make sure it's up to date.
* An `ssh` call will execute [bin/deploy.bash](../bin/deploy.bash).<br>This script will:
  * Generate a changelog and keep it in memory for later.
  * Update production's git repository from the `master` branch.
  * Resolve the current & next versions of the project (in an env var).
  * Execute [bin/deploy_scripts.bash](../bin/deploy_scripts.bash).<br>This script will:
    * Install NodeJS dependencies.
    * Dump public assets.
    * Run `composer install` with production parameters.
    * Clear and warm up the cache.
    * Execute migrations and make sure the database schema is valid.
  * Restart web servers.
  * Send the changelog by email to the core team so we get a notification of a successful deploy.
  * Execute `post_deploy.bash` script in the parent directory if it exists. This file contains prod-specific data and
    that is why it is not 100% versioned. However an example can be found at in the dev files at 
    [post_deploy.bash](../_dev_files/post_deploy.bash)

The reason why there are two scripts `deploy.bash` and `deploy_scripts.bash` is that when the first one updates the
repository, it will not benefit from potential scripts updates, because it's already running.

This allows adding new production hooks in the scripts file so they can be executed right during deployment.
