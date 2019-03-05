Jordan Shurmer's Notes
======================

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

Currently hosted using [surge.sh](https://surge.sh).

```
surge ./public jordan.shurmer.family
```


