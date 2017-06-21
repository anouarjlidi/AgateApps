
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# Deploy on heroku

## Automatic deploy

The `prod` branch is configured on Heroku to be deployed automatically when a push is made to it and when CI succeeds.

Nothing to do there, just push to the `prod` branch and it will deploy a few minutes later.

## Deploy manually

Add heroku as new remote for your git repository:

```bash
$ git remote add heroku https://git.heroku.com/agate-apps.git
```

Push the branch you want to put on production by pushing to heroku:

```bash
$ git push heroku master
```
