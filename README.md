DOCKER-COMPOSE PHP
==================

**Docker-compose PHP** is a [Docker-compose](https://docs.docker.com/compose/) SDK written in PHP. This library is still a work in progress.
Not much is supported yet, but the goal is to reach 100% of docker-compose options support.

This is supported for docker version 1.9 and docker-compose version 1.5.

[![Travis-CI](https://travis-ci.org/omauger/docker-compose-php.svg?branch=master)](https://travis-ci.org/omauger/docker-compose-php) [![Documentation Status](https://readthedocs.org/projects/docker-compose-php/badge/?version=latest)](http://docker-compose-php.readthedocs.org/en/latest/?badge=latest)

Versioning
----------

There is no *stable* version yet and docker-compose is rapidly evolving, but we still try to semantically version the library according to [semver](http://semver.org/), but shifted a little bit:

* **MAJOR** version number stays to 0 until all options of docker-compose 1.5 are covered
* **MINOR** version number is incremented when a backward incompatible change is made
* **PATCH** version number is incremented when a new feature is added

So basically, if you want the `0.1` version set, pull the tag`0.1.0` and you should be fine.

Installation
------------

The recommended way to install Docker PHP is of course to use [Composer](http://getcomposer.org/):

```json
{
    "require": {
        "omauger/docker-compose-php": "@dev"
    }
}
```

**Note**: there is no stable version of Docker-compose PHP yet.

Usage
-----

See [the documentation](http://docker-compose-php.readthedocs.org/en/latest/)
Run tests
---------
```
./scripts/tests.sh
```

Contributing
------------
[Ophélie Mauger](https://github.com/omauger)

License
-------

The MIT License (MIT)

Copyright (c) 2015 Forges Alterway

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
