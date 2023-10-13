<?php

function dev($request, $response)
{
   $file = parse_ini_file("../src/Config/Key.ini");
   return sendData($request, $response, 200, hash_equals(hash_hmac($file['hash'], 'yo' , $file['secret'], false), '9b81a7238b0dfacc7c5e3a47e10b1a0ffc05901a6e3c8280ce233b2a0176f853'));
}