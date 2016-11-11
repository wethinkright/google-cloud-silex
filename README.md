# Google Cloud PHP Silex Service Provider

[![Build Status](https://travis-ci.org/wethinkright/google-cloud-silex.svg?branch=master)](https://travis-ci.org/wethinkright/google-cloud-silex) [![codecov](https://codecov.io/gh/wethinkright/google-cloud-silex/branch/master/graph/badge.svg)](https://codecov.io/gh/wethinkright/google-cloud-silex)

This package makes integrating
[Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php) into
your Silex application quick and easy.

## Installation

````bash
$ composer require wethinkright/google-cloud-silex
````

## Usage

To learn how ServiceProviders work and how they can be loaded in your
application, refer to the
[Silex Documentation](http://silex.sensiolabs.org/doc/master/providers.html#loading-providers).

````php
<?php

use Silex\Application;
use WeThinkRight\GoogleCloudSilex\GoogleCloudProvider;

$app = new Application;
$app->register(new GoogleCloudProvider(), [
    'cloud.config' => [
        'keyFilePath' => '/path/to/service/account/credentials.json'
    ]
]);

$pubsub = $app['cloud']->pubsub();
````

### Services

Services are provided for your convenience for each of the Google Cloud PHP
APIs.

````php
$bigquery = $app['cloud.bigquery'];
$datastore = $app['cloud.datastore'];
$logging = $app['cloud.logging'];
$language = $app['cloud.language'];
$pubsub = $app['cloud.pubsub'];
$speech = $app['cloud.speech'];
$storage = $app['cloud.storage'];
$translate = $app['cloud.translate'];
$vision = $app['cloud.vision'];
````

### Configuration

To learn how to configure Google Cloud PHP, refer to the
[`Google\Cloud\ServiceBuilder::__construct()`](https://googlecloudplatform.github.io/google-cloud-php/#/docs/latest/servicebuilder?method=__construct)
documentation.

* The configuration array can be provided when registering the Service Provider:

````php
<?php

use Silex\Application;
use WeThinkRight\GoogleCloudSilex\GoogleCloudProvider;

$app = new Application;
$app->register(new GoogleCloudProvider(), [
    'cloud.config' => [
        'keyFilePath' => '/path/to/service/account/credentials.json'
    ]
]);
````

* Or, it can be assigned prior to registering the Service Provider:

````php
<?php

use Silex\Application;
use WeThinkRight\GoogleCloudSilex\GoogleCloudProvider;

$app = new Application;

$app['cloud.config'] = [
    'keyFilePath' => '/path/to/service/account/credentials.json'
];

$app->register(new GoogleCloudProvider());
````

## License

This package is licensed under the Apache 2.0 software license. See LICENSE for
more information.
