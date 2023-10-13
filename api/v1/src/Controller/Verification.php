<?php

function getVerification($request, $response)
{
    try
    {
        //database
        $db = new \App\Config\Database();
        $db->connect();
        $db = null;
        return sendStatus($request, $response, 200);
    }
    catch (PDOException $e)
    {
        return sendStatus($request, $response, 500);
    }
}