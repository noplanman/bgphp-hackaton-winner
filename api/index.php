<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/./vendor/autoload.php';
ini_set('opcache.enable', 0);

$app = new \Slim\App;

$GLOBALS['user1'] = uniqid('123', 123);
$GLOBALS['user2'] = uniqid('123', 123);

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/join', function (Request $request, Response $response) {
    $user = ['id' => $GLOBALS['user1']];
    $response->getBody()->write(json_encode($user));

    return $response;
});

$app->get('/players', function (Request $request, Response $response) {
    $player_scores = [
        ['uid' => $GLOBALS['user1'], 'score' => 1],
        ['uid' => $GLOBALS['user2'], 'score' => 2],
    ];
    $response->getBody()->write(json_encode($player_scores));

    return $response;
});

$app->post('/bet', function (Request $request, Response $response) {
    $number = $request->getParsedBody();

    $response->getBody()->write(json_encode($number));

    return $response;
});

$app->run();
