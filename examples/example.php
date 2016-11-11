<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

include __DIR__ .'/../vendor/autoload.php';

use Silex\Application;
use WeThinkRight\GoogleCloudSilex\GoogleCloudProvider;

$app = new Application;
$app->register(new GoogleCloudProvider());

$app->get('publish', function (Application $app) {
    $pubsub = $app['cloud.pubsub'];

    $topic = $pubsub->topic('provider-test-topic');

    if (!$topic->exists()) {
        $topic->create();
    }

    $topic->publish([
        'data' => 'Message published!',
        'attributes' => [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'time' => time()
        ]
    ]);
});

$app->get('pull', function (Application $app) {
    $pubsub = $app['cloud']->pubsub();

    $topic = $pubsub->topic('provider-test-topic');

    if (!$topic->exists()) {
        $topic->create();
    }

    $subscription = $topic->subscription('provider-test-subscription');
    if (!$subscription->exists()) {
        $subscription->create();
    }

    foreach ($subscription->pull() as $message) {
        echo sprintf(
            '<strong>%s</strong> IP: <em>%s</em> Time: <em>%s</em><hr>',
            $message->data(),
            $message->attribute('ip'),
            $message->attribute('time')
        );
    }
});

$app['debug'] = true;
$app->run();
