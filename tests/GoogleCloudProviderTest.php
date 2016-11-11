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

namespace WeThinkRight\GoogleCloudSilex\Tests;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\NaturalLanguage\NaturalLanguageClient;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\ServiceBuilder;
use Google\Cloud\Speech\SpeechClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Vision\VisionClient;
use Silex\Application;
use WeThinkRight\GoogleCloudSilex\GoogleCloudProvider;

class GoogleCloudProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        $this->app = new Application;
    }

    public function testRegister()
    {
        $provider = new GoogleCloudProviderStub();
        $this->app->register($provider);

        $this->assertInstanceOf(ServiceBuilder::class, $this->app['cloud']);
        $this->assertEquals([], $provider->config);
    }

    public function testRegisterWithConfigInRegister()
    {
        $provider = new GoogleCloudProviderStub();
        $config = ['cloud.config' => ['foo' => 'bar']];

        $this->app->register($provider, $config);

        $this->app['cloud'];

        $this->assertEquals($config['cloud.config'], $provider->config);
    }

    public function testRegisterWithConfigInDI()
    {
        $provider = new GoogleCloudProviderStub();
        $this->app['cloud.config'] = ['foo' => 'bar'];

        $this->app->register($provider);

        $this->app['cloud'];

        $this->assertEquals($this->app['cloud.config'], $provider->config);
    }

    public function testEachServiceType()
    {
        $provider = new GoogleCloudProviderStub();
        $this->app->register($provider, ['cloud.config' => ['projectId' => 'fake-project', 'key' => 'foo']]);

        $this->assertInstanceOf(BigQueryClient::class, $this->app['cloud.bigquery']);
        $this->assertInstanceOf(DatastoreClient::class, $this->app['cloud.datastore']);
        $this->assertInstanceOf(LoggingClient::class, $this->app['cloud.logging']);
        $this->assertInstanceOf(NaturalLanguageClient::class, $this->app['cloud.language']);
        $this->assertInstanceOf(PubSubClient::class, $this->app['cloud.pubsub']);
        $this->assertInstanceOf(SpeechClient::class, $this->app['cloud.speech']);
        $this->assertInstanceOf(StorageClient::class, $this->app['cloud.storage']);
        $this->assertInstanceOf(TranslateClient::class, $this->app['cloud.translate']);
        $this->assertInstanceOf(VisionClient::class, $this->app['cloud.vision']);
    }

    public function testInstantiate()
    {
        $sb = new GetServiceBuilder;
        $this->assertInstanceOf(ServiceBuilder::class, $sb->sb());
    }
}

class GoogleCloudProviderStub extends GoogleCloudProvider
{
    public $config;

    protected function instantiate($config)
    {
        $this->config = $config;

        return new ServiceBuilder($config);
    }
}

class GetServiceBuilder extends GoogleCloudProvider
{
    public function sb()
    {
        return $this->instantiate([]);
    }
}
