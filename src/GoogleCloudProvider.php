<?php
/**
 * Copyright 2016 John Pedrie
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace WeThinkRight\GoogleCloudSilex;

use Google\Cloud\ServiceBuilder;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * A Silex Service Provider for Google Cloud PHP.
 */
class GoogleCloudProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['cloud'] = function ($app) {
            $config = (isset($app['cloud.config']))
                ? $app['cloud.config']
                : [];

            return $this->instantiate($config);
        };

        $app['cloud.bigquery'] = function ($app) {
            return $app['cloud']->bigquery();
        };

        $app['cloud.datastore'] = function ($app) {
            return $app['cloud']->datastore();
        };

        $app['cloud.logging'] = function ($app) {
            return $app['cloud']->logging();
        };

        $app['cloud.language'] = function ($app) {
            return $app['cloud']->naturalLanguage();
        };

        $app['cloud.pubsub'] = function ($app) {
            return $app['cloud']->pubsub();
        };

        $app['cloud.speech'] = function ($app) {
            return $app['cloud']->speech();
        };

        $app['cloud.storage'] = function ($app) {
            return $app['cloud']->storage();
        };

        $app['cloud.translate'] = function ($app) {
            return $app['cloud']->translate();
        };

        $app['cloud.vision'] = function ($app) {
            return $app['cloud']->vision();
        };
    }

    protected function instantiate($config)
    {
        return new ServiceBuilder($config);
    }
}
