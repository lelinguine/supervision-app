<?php
        function sendStatus($request, $response, $code)
        {
            //status http
            $response->getBody()->write(json_encode(["request" => $_SERVER['REQUEST_METHOD'], "status" => createStatus($code), "code" => $code]));
            return $response->withHeader('content-type', 'application/json')->withStatus($code);
        }
        //....................................................................................
        function sendData($request, $response, $code, $data)
        {
            //data
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('content-type', 'application/json')->withStatus($code);
        }
        //....................................................................................
        function createStatus($code)
        {
            if ($code == 200)
            {
                return "OK";
            }
            else if ($code == 201)
            {
                return "Created";
            }
            else if ($code == 400)
            {
                return "Bad Request";
            }
            else if ($code == 401)
            {
                return "Unauthorized";
            }
            else if ($code == 405)
            {
                return "Method Not Allowed";
            }
            else if ($code == 409)
            {
                return "Conflict";
            }
            else if ($code == 500)
            {
                return "Internal Server Error";
            }
            else if ($code == 502)
            {
                return "Bad Gateway";
            }
            else if ($code == 503)
            {
                return "Service Unavailable";
            }
            else
            {
                return "Undefined";
            }
        }
    





