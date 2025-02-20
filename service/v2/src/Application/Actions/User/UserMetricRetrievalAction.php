<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

use App\Infrastructure\Security\Token;

class UserMetricRetrievalAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $requestData = $this->request->getParsedBody();
        $requestData = $requestData['data']['user'];
        $token = $this->container->get(Token::class);

        // if (!in_array($token->authToken($requestData['token']), Token::AUTH_LEVELS, true)) {
        //     throw new Exception("Niveau d'autorisation invalide.");
        // } else {
            $data = [
                //'metric' => ['level' => runSocket("!MEAS")],
                'metric' => ['level' => rand(40, 80)],
            ];
            $message = 'Données récupérées.';
            $status = 200;
        //}

        $response = $this->response;
        $response->getBody()->write(json_encode(['message' => $message, 'data' => $data]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}