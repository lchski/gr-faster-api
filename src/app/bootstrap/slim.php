<?php

// Configure our Slim instance.
$configuration = [
    'settings'             => [
        'displayErrorDetails' => env('SLIM_DEBUG', false),
    ],
];

// Create our custom Slim container.
$c = new \Slim\Container($configuration);

// Configure Slim's HTTP caching plugin.
$c['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};

// Register REST API client
$c['api'] = function ($c) {
    // Create handler, to insert middleware onto.
    $stack = \GuzzleHttp\HandlerStack::create();

    // Set up caching system: array cache (doesn't persist), followed by filesystem cache (persists).
    if (!isset($_GET['nocache'])) {
        $stack->push(
            new \Kevinrob\GuzzleCache\CacheMiddleware(
                new \Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy(
                    new \Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage(
                        new \Doctrine\Common\Cache\ChainCache([
                            new \Doctrine\Common\Cache\ArrayCache(),
                            new \Doctrine\Common\Cache\FilesystemCache('/tmp/'),
                        ])
                    )
                )
            ),
            'cache'
        );
    }

    return new \GuzzleHttp\Client([
        // API URL
        'base_uri' => env('API_URL', 'https://www.goodreads.com/'),
        // Custom handler, to include middleware.
        'handler'  => $stack,
        // API query parameters
        'query'    => [
            'key'  => env('API_KEY', ''),
        ]
    ]);
};

// Boot up our Slim instance.
$app = new \Slim\App($c);

// Add our global middleware.
$app->add(new \Lchski\TrailingSlashMiddleware);

$app->add(new \Slim\HttpCache\Cache('private', 300, true));
