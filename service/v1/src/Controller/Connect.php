<?php

function postConnect($request, $response)
{
    //input
    $input = json_decode(file_get_contents('php://input'));
    //test input
    if(!empty($input->identifiant) && !empty($input->password))
    {
        //sql
        $sql = "SELECT `password`, `auth`, `nom`, `prenom`, `image`, `installation_id`, `identifiant` FROM utilisateur WHERE identifiant LIKE '$input->identifiant'";
        try
        {
            //database
            $db = new \App\Config\Database();
            $data = $db->manageData($sql);
            $db = null;
            if(!empty($data))
            {
                //user
                $user = $data[0];
                //.ini
                $file = parse_ini_file("../src/Config/Key.ini");
                //password
                if(hash_equals(hash_hmac($file['hash'], $input->password , $file['secret'], false), $user['password']))
                {
                    $send = ['nom' => $user['nom'],
                            'prenom' => $user['prenom'],
                            'image' => $user['image'],
                            'auth' => $user['auth'],
                            'token' => getToken($user, false)
                    ];
                    return sendData($request, $response, 200, $send);
                }
            }
        }
        catch (PDOException $e)
        {
            return sendStatus($request, $response, 500);
        }
        return sendStatus($request, $response, 401);
    }
    return sendStatus($request, $response, 400);
}
//........................................................................
function updatePassword($request, $response)
{
    //input
    $input = json_decode(file_get_contents('php://input'));
    if(!empty($input->password))
    {
        //token
        $jwt = decodeToken();
        $identifiant = $jwt[1]->key;
        //.ini
        $file = parse_ini_file("../src/Config/Key.ini");
        //hash
        $password = hash_hmac($file['hash'], $input->password , $file['secret'], false);
        //sql
        $sql = "UPDATE utilisateur SET `password` = '$password' WHERE identifiant LIKE '$identifiant'";
        try
        {
            //database
            $db = new \App\Config\Database();
            $db->manageData($sql);
            $db = null;
            return sendStatus($request, $response, 201);
        }
        catch (PDOException $e)
        {
            return sendStatus($request, $response, 500);
        }
    }
    return sendStatus($request, $response, 400);
}
