<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Psr\Container\ContainerInterface;

use App\Application\Actions\User\ConnectUserAction;
use App\Application\Actions\User\UserMetricRetrievalAction;

return function (App $app) {
    $app->group('/service/v2', function ($app)
    {
        $app->options('/{routes:.*}', function (Request $request, Response $response) {
            return $response;
        });

        $app->get('/', function (Request $request, Response $response) {
            $data = [
                'app' => [
                    'version' => $_ENV['APP_VERSION'],
                    'php' => $_ENV['PHP_VERSION']
                ]
            ];
            $message = 'Connexion réussie.';
            $response->getBody()->write(json_encode(['message' => $message, 'data' => $data]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        $app->post('/dev', function (Request $request, Response $response) {
            $data = [
                $request->getParsedBody(),
                'result' => hash_equals(hash_hmac($_ENV['HASH_ALGO'], 'martin' , $_ENV['HASH_SECRET'], false), 'ab6512a76dee1c57aa10e9be4f44b459dec319a6e9eea31b5aa3a8be3964d5d1'),
                //'result' => hash_hmac($_ENV['HASH_ALGO'], 'password' , $_ENV['HASH_SECRET'], false),
            ];
            $message = 'Connexion réussie.';
            $response->getBody()->write(json_encode(['message' => $message, 'data' => $data]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        $app->post('/connect', ConnectUserAction::class);
        $app->post('/metric', UserMetricRetrievalAction::class);
    });
};