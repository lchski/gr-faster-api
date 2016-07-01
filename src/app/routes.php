<?php

$app->get('/', function($request, $response, $args) {
    return 'Hello!';
})->setName('index');

$app->get('/shelf/{userId}/{shelfName}', '\\Lchski\\MainController')->setName('getShelfBooks');

