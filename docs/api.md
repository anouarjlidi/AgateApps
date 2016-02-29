
#### Documentation index

* [Documentation](../README.md)
* [Routing](routing.md)
* [General technical informations](technical.md)
* [Set up a vhost](vhosts.md)
* [API / webservices](api.md)
* [Esteren Maps library](maps.md)
* [Deploy](deploy.md)

# API / webservices

:warning: The bundle that generates webservices has to be refactored for a more "config-only" solution.
*(or [OrbitaleApiBundle](https://github.com/Orbitale/ApiBundle) has to be finished...)*

The webservices are a big part of Esteren Maps, because the Javascript library developed for it makes a lot of use of
 AJAX queries to retrieve contents, but the Maps backend also use these webservices to handle object updates.

The bundle used, `PierstovalApiBundle`, is a primitive version of [OrbitaleApiBundle](https://github.com/Orbitale/ApiBundle).

It makes use of [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle), but actually many things are tweaked
 to respond "our" needs, and some standards are not respected because the evolution of `OrbitaleApiBundle` was faster
 than the support of this bundle in this application.

Every response object is serialized with [JMSSerializer](https://github.com/schmittjoh/serializer), so all the received
 objects will follow your `ExclusionPolicy` and different `Expose` or `Exclude` settings in `jms_serializer` config or
 in the `@Serializer` annotation in the entity.

## Services

First, you must configure services. A service is composed of a name and an Entity.

All webservices are accessible from the domain configured in the `esteren_domains.api` parameter and the routes are
 the following:

| Route name                    | Method | Route pattern
| ----------------------------- | ------ | -------------
| pierstoval_api_cget           | GET    | `/{_locale}/{serviceName}`
| pierstoval_api_get            | GET    | `/{_locale}/{serviceName}/{id}`
| pierstoval_api_get_subrequest | GET    | `/{_locale}/{serviceName}/{id}/{subElement}`
| pierstoval_api_put            | PUT    | `/{_locale}/{serviceName}`
| pierstoval_api_post           | POST   | `/{_locale}/{serviceName}/{id}`
| pierstoval_api_delete         | DELETE | `/{_locale}/{serviceName}/{id}`

* `cget`: This route allows to get a collection of objects of the specified entity.

* `get`: This route retrieves a single object with its primary key (even if this primary key is not called `id`).

* `subrequest`

    This is the great point of this Api generator.

    This route can retrieve any element recursively depending on three parameters:
    * The parameter has to be a valid entity attribute.
    * If the attribute is a collection, you can fetch one element in this collection by appending its primary key.
    * The value must not be null (or it'll return an empty value).

    *Example:*
    `/api/pages/1/title` will retrieve the `title` attribute of the `Page` object with `id` equals to `1`.

    Deep requests can then be done, like this: `/api/pages/1/children/2/category/name`, etc.

* `post` and `put`

 The PUT route is only used to INSERT datas.

 The POST route is only used to UPDATE datas.

 Check [OrbitaleApiBundle's documentation](https://github.com/Orbitale/ApiBundle#post-and-put-routes) for more infos.

## CORS configuration

First, check out [what is CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing).

When using the backoffice to manage the map, we face a problem:
the backend is under one subdomain, usually `back.esteren.dev` in dev, and the webservices are under another
subdomain, usually `api.esteren.dev`.

To manage non-GET HTTP requests, a full setup must be configured in your app.

If you are developing locally, you won't be able to access the webservices "manually" because they're protected by
[NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle)'s configuration (check in `app/config/_app.yml`).

For this, you will have to allow `127.0.0.1` as a valid origin.

The same kind of requirement is also added to `PierstovalApiBundle` so be sure you don't face any issue in debugging
 the webservices results.

## Problems that you may encounter

If CORS requests fail, be sure that all domains are set.

Also, make sure that `always_populate_raw_post_data` is set to `-1` because Ajax requests are made with a raw payload
encoded in JSON, and some PHP configurations need this to avoid populating the `$HTTP_RAW_POST_DATA` var, which is
deprecated, and the deprecation may trigger an error that would send text to the browser before sending the response,
and not allow the application to send the correct CORS headers.
