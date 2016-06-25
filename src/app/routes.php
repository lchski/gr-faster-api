<?php

$app->get('/', function($request, $response, $args) {
    return 'Hello!';
})->setName('index');

$app->get('/shelf/{userId}/{shelfName}', function($request, $response, $args) {
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(
            json_encode(
                xmlToArray(
                    simplexml_load_string(
                        $this->api->get('review/list',
                            ['query' => array_merge($this->api->getConfig('query'), [
                                'v' => 2,
                                'id' => $args['userId'],
                                'shelf' => $args['shelfName'],
                            ])]
                        )->getBody()
                    )
                ), JSON_PRETTY_PRINT
            )
        );
});

