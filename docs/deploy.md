
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Deploy](deploy.md)

# Deploy the project

A `post-receive` script has been set up on the production server, inside a bare
repo that mirrors this actual repository.

This script is based on [this Gist by Pierstoval]
(https://gist.github.com/Pierstoval/27e8f309034fa0ababa1) and you should see it
to know how it works and what it does.

The script for this repo's deployment executes only 2 scripts to deploy:

* `composer install`
* `php app/console doctrine:schema:update --force --complete --dump-sql --env=prod`

As Composer is set up in [composer.json](../composer.json) automatically in the
`post-install-cmd` script to clear the cache, install npm dependencies and dump
assets, there is nearly nothing else to do to deploy the project.

## Setup deploy environment

To deploy from your machine, set up your local repository with this remote:

```bash
$ git remote add prod ssh://my_ssh_user@188.165.206.57:2010/var/www/esteren.org/portal_repo
```

The ssh user `my_ssh_user` should obviously be replaced by your own ssh user.
This user must have the right to access and push to this repository.

## Deploy

**Note:** Deployment can only be made based on a **tag**.

Just execute a script like this one:

```bash
$ git push prod v0.6.7
```

This will fetch the tag remotely, create a branch named `release_v0.6.7` and
check it out with `git checkout release_v0.6.7`.
After that, all scripts will be executed.

**Note:** be sure the branch does not exist, else you will have to remove it
manually from your server.