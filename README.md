# MeCms/Banners plugin

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Build Status](https://api.travis-ci.com/mirko-pagliai/me-cms-banners.svg?branch=master)](https://travis-ci.com/mirko-pagliai/me-cms-banners)
[![codecov](https://codecov.io/gh/mirko-pagliai/me-cms-banners/branch/master/graph/badge.svg?token=2G1HR8CVWG)](https://codecov.io/gh/mirko-pagliai/me-cms-banners)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/8ede1aceb5cc47ec8b3c6fb23cbaee72)](https://www.codacy.com/gh/mirko-pagliai/me-cms-banners/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=mirko-pagliai/me-cms-banners&amp;utm_campaign=Badge_Grade)
[![CodeFactor](https://www.codefactor.io/repository/github/mirko-pagliai/me-cms-banners/badge)](https://www.codefactor.io/repository/github/mirko-pagliai/me-cms-banners)

*MeCms/Banners* plugin allows you to handle banners with [MeCms platform](//github.com/mirko-pagliai/cakephp-for-mecms).

To install:
```bash
$ composer require --prefer-dist mirko-pagliai/me-cms-banners
```

Then load the plugin and run migrations to create the database tables:
```bash
$ bin/cake plugin load MeCms/Banners
$ bin/cake migrations migrate -p MeCms/Banners
```


Please, refer to the CookBook for [more information on loading plugins](https://book.cakephp.org/4/en/plugins.html#loading-a-plugin).

## Versioning
For transparency and insight into our release cycle and to maintain backward compatibility, *MeCms/Banners* will be maintained under the
[Semantic Versioning guidelines](http://semver.org).
