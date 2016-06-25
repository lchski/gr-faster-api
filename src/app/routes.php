<?php

$app->get('/', function($request, $response, $args) {
    return 'Hello!';
})->setName('index');

