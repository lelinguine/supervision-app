<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
//........................................................................
require '../src/Config/Token.php';
require '../src/Config/Socket.php';
require '../src/Config/Response.php';
//........................................................................
require '../src/Controller/Connect.php';
require '../src/Controller/Sound.php';
require '../src/Controller/Verification.php';
//........................................................................
require '../src/Controller/dev.php';
//........................................................................
return function (App $app)
{
    $app->group('/supervision-app/api/v1', function ($app)
    {
        //........................................................................
        //dev
        $app->post('/dev', 'dev');
        //........................................................................
        //version
        $app->get('/version', function ($request, $response)
        {
            $file = parse_ini_file("../src/Config/Version.ini");
            return sendData($request, $response, 200, ['version' => $file['version'], 'php' => $file['php']]);
        });
        //........................................................................
        //verification bdd
        $app->get('/verification', 'getVerification');
        //........................................................................
        //connect
        $app->post('/connect', 'postConnect');
        //........................................................................
        //auth
        $auth = authToken();
        //........................................................................
        //user
        if($auth == 'user' || $auth == 'admin')
        {
            //son
            $app->post('/son', 'postSound');
            //password
            $app->put('/password', 'updatePassword');
            //........................................................................
            //admin
            if($auth == 'admin')
            {
                //palier
                $app->post('/palier', 'postPalier');
                $app->put('/palier', 'updatePalier');
            }
        }
        //........................................................................
        //bad token
        else if($auth == 'null')
        {
            $app->any('/{routes:.*}', function ($request, $response)
            {
                return sendStatus($request, $response, 401);
            });
        }
    });
};
