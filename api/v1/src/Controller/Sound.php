<?php

function postSound($request, $response)
{
    //socket receive sound level dB
    //$son = runSocket("!MEAS");
    $son = rand(40, 60);
    //........................................................................
    //test is int
    if(is_numeric($son))
    {
        //erreur double lecture socket
        if($son > 180)
        {
            $son = substr($son, -2);
        }
        //decode token
        $jwt = decodeToken();
        $installation = $jwt[1]->installation;
        //sql
        $sql = "SELECT `type`, `valeur` FROM curseur WHERE installation_id = '$installation'";
        try
        {
            //database
            $db = new \App\Config\Database();
            $data = $db->manageData($sql);
            $db = null;
        }
        catch (PDOException $e)
        {
            return sendStatus($request, $response, 500);
        }
        //........................................................................
        //round measure
        $son = round($son, 0, PHP_ROUND_HALF_UP);
        //test value
        $couleur = 0;
        for ($i = 0; $i <= 1; $i++)
        {
            if($data[$i]['type'] == "minimum" && $son<$data[$i]['valeur'])
            {
                $couleur = "vert";
            }
            else if($data[$i]['type'] == "maximum" && $son>=$data[$i]['valeur'])
            {
                $couleur = "rouge";
            }
            else if($i == 1 && $couleur == 0)
            {
                $couleur = "orange";
            }
        }
        //........................................................................
        //sql
        $sql = "SELECT `alerte`, `couleur` FROM `message` WHERE type = '$couleur' AND installation_id='$installation'";
        try
        {
            //database
            $db = new \App\Config\Database();
            $data = $db->manageData($sql);
            $db = null;
            //message
            $message = ['alerte' => $data[0]['alerte'],
                        'couleur' => $data[0]['couleur'],
                        'valeur' => $son
            ];
            return sendData($request, $response, 200, $message);
        }
        catch (PDOException $e)
        {
            return sendStatus($request, $response, 500);
        }
    }
    return sendStatus($request, $response, 502);
}
//........................................................................
function postPalier($request, $response)
{
    //decode token
    $jwt = decodeToken();
    $installation = $jwt[1]->installation;
    //sql
    $sql = "SELECT `type`, `valeur` FROM `curseur` WHERE installation_id='$installation'";
    try
    {
        //database
        $db = new \App\Config\Database();
        $data = $db->manageData($sql);
        $db = null;
        //curseur
        $cursor = ['minimum' => "0",
                    'maximum' => "130"
        ];
        //minimum & maximum
        for ($i = 0; $i <= 1; $i++)
        {
            if($data[$i]['type'] == "minimum")
            {
                $cursor['minimum'] = $data[$i]['valeur'];
            }
            else if ($data[$i]['type'] == "maximum")
            {
                $cursor['maximum'] = $data[$i]['valeur'];
            }
        }
        return sendData($request, $response, 200, $cursor);
    }
    catch (PDOException $e)
    {
        return sendStatus($request, $response, 500);
    }
}
//........................................................................
function updatePalier($request, $response)
{
    //input
    $input = json_decode(file_get_contents('php://input'));
    //test recv
    if(!empty($input->maximum) && !empty($input->minimum) && is_numeric($input->maximum) && is_numeric($input->minimum))
    {
        //decode token
        $jwt = decodeToken();
        $installation = $jwt[1]->installation;
        try
        {
            //sql
            $sql = "UPDATE `curseur` SET `valeur` = '$input->minimum' WHERE `installation_id`='$installation' AND `type`='minimum'";
            //database
            $db = new \App\Config\Database();
            $db->manageData($sql);
            $db = null;
            //........................................................................
            //sql
            $sql = "UPDATE `curseur` SET `valeur` = '$input->maximum' WHERE `installation_id`='$installation' AND `type`='maximum'";
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