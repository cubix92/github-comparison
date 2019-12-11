# ComparisonApp

## About

This is a simple web application using Zend Framework 3 whose purpose is to compare any 
two repositories fetching from GitHub. It takes links or names of any two public GitHub 
repositories and return the basics statistics of these repositories together with their 
comparison. For this reason added a simple formula calculating scoring of each repository:

```bash
scores = stars + forks + watchers + closed pull requests - open pull requests
```

## Installation

You can easily install the application on your machine by following the instructions:

- clone this repository.
- install all dependencies using composer (this project includes composer.phar).
- if you have got PHP 7.2 or above you can simply run `composer serve`, but if you 
don't have proper PHP installation on your machine you can use the docker container 
included in this project.

Of course if you want to install application manually, you can also copy 
`vhost-comparison.conf` from the application main directory. It's up to you.

## Docker

This application provides a `docker-compose.yml` for use with 
[docker-compose](https://docs.docker.com/compose/). It uses the `Dockerfile` provided 
as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

Before that you have to add to your `hosts`:

```bash
10.5.0.2        comparison.loc
```

At this point, you can visit `comparison.loc` to see the site running. This ways brings 
you also configure xdebug and other important stuffs.

## Usage

After you successfull run the application, you will see swagger documentation on 
the home page. So you can test ComparisonApp in this way.

If from any reason you don'w want to using swagger documentation, you can using API via GET 
method with resource `api/v1/compare` with two require parameters `compare` and `to`.

You can send links or names of any two public GitHub repositories.

## TODO

- Because this app is actually very small I mixed integration and unit tests, but in the
future it should be separated.
- Adding hypermedia controls to reach third level of Richardson Maturity Model. Using HATEOAS
extends possibilities of API.
- Adding support for more repositories. 
- For such reason we should also work on optimization. We can, for example, change GET into 
POST. Thanks to that change I can save comparison in database and handle it after processing.
