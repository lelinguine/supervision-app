<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

use App\Infrastructure\Persistence\Database;
use App\Infrastructure\Security\Token;

class ConnectUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $requestData = $this->request->getParsedBody();
        $requestData = $requestData['data']['user'];
        $database = $this->container->get(Database::class);
        $token = $this->container->get(Token::class);
  
        $sql = "SELECT * FROM user WHERE pseudo = :pseudo AND password = :password";

        $user = $database->executeQuery($sql, [
            ':pseudo' => $requestData['pseudo'],
            ':password' => hash_hmac('sha256', $requestData['password'], $_ENV['HASH_SECRET'], false)
        ]);

        if ($user) {
            unset($user[0]['password']);
            $user[0]['token'] = $token->generateToken($user[0], false);
            $data = [
                'user' => $user[0]
            ];
            $message = 'Connexion réussie.';
            $status = 200;
        } else {
            $data = [];
            $message = 'Identifiant ou mot de passe incorrect.';
            $status = 401;
        }

        $response = $this->response;
        $response->getBody()->write(json_encode(['message' => $message, 'data' => $data]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
