<?php

function dev($request, $response)
{
   $file = parse_ini_file("../src/Config/Key.ini");

   //return sendData($request, $response, 500, hash_hmac($file['hash'], 'martin' , $file['secret'], false));

   return sendData($request, $response, 200, hash_equals(hash_hmac($file['hash'], 'martin' , $file['secret'], false), 'ab6512a76dee1c57aa10e9be4f44b459dec319a6e9eea31b5aa3a8be3964d5d1'));
}