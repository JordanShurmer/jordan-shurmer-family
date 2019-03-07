Jordan Shurmer's Notes
======================

[![Netlify Status](https://api.netlify.com/api/v1/badges/5bebbdd8-03a8-41e4-a9ca-e974a36e231a/deploy-status)](https://app.netlify.com/sites/jordan-shurmer-family/deploys)

> [http://jordan.shurmer.family](http://jordan.shurmer.family)

A website for Jordan's notes and thoughts and things.

Development
-----------

This is a Zola project, so you can use Zola to serve the site from `localhost` while working on it.

```
zola serve
```

Building
--------

Built as a static site, using [Zola](https://www.getzola.org).

```
# set the base_url to //jordan.shurmer.family (protocol agnostic)
zola build -u //jordan.shurmer.family
```


Hosting
-------

Currently hosted using [netlify](https://www.netlify.com). It should auto-publish when you push a change to `master`.



