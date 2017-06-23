
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Corahn Rin / Character manager](character_manager.md)
* [Deploy](deploy.md)

# Heroku

App is hosted on [Heroku](https://www.heroku.com/), and deploys can be made only manually from command-line.

Add heroku as new remote for your git repository:

```bash
$ git remote add heroku https://git.heroku.com/agate-apps.git
```

Push the branch you want to put on production by pushing to heroku:

```bash
$ git push heroku master
```
