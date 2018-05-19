
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# Deploy the project

A `post-receive` script has been set up on the production server, inside a bare
repo that mirrors this actual repository.

To push to prod, simply execute `bin/push`, either the `bash` or `cmd` depending on your env.

This command will:

* Push the `master` branch to Github.
* Connect to production via `ssh`.
* Execute [bin/deploy.bash](../bin/deploy.bash).<br>This script will:
  * Update production's git repository from the `master` branch.
  * Generate a changelog.
  * Execute [bin/deploy_scripts.bash](../bin/deploy_scripts.bash).<br>This script will:
    * Run `composer install` with production parameters.
    * Clear and warm up the cache.
    * Make sure the database schema is still valid.
    * Install NodeJS dependencies.
    * Dump public assets.
  * Restart web servers.
  * Send the changelog by email to the core team so we get a notification of a successful deploy.
