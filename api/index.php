<?php

namespace FourCheese;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use NoSQLite;

require __DIR__ . '/../vendor/autoload.php';
ini_set('opcache.enable', 0);

$app = new \Slim\App;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/join', function (Request $request, Response $response) {

    $storage = new SqliteStorageController();
    $uid = $storage->addPlayer();

    $response->getBody()->write(json_encode($uid));

    return $response;
});

$app->get('/players', function (Request $request, Response $response) {
    $storage = new SqliteStorageController();
    $players = $storage->getPlayers();

    $response->getBody()->write(json_encode($players));

    return $response;
});

$app->post('/bet', function (Request $request, Response $response) {
    $input = $request->getParsedBody();

    $uid = $input['uid'];
    $bet = $input['bet'];

    $nsql = new NoSQLite\NoSQLite('4cheese.sqlite');

    $store = $nsql->getStore('bets');

    $store->set($uid, json_encode(['bet' => $bet]));

    $response->getBody()->write(var_dump($input));

    return $response;
});

$app->get('/bets', function (Request $request, Response $response) {

    $nsql = new NoSQLite\NoSQLite('4cheese.sqlite');

    $store = $nsql->getStore('bets');

    $val = $store->getAll();

    $response->getBody()->write(json_encode($val));
});


$app->run();
