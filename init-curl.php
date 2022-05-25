<?php

// This is used to setup the parameters needed to start a curl session

$headers = array(
    "Authorization: Basic YWRkc2VydmljZW1lZGlhOmtuRGJrR0JDUFljSDdZN2c=",
    
);

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true
]);

return $ch;
