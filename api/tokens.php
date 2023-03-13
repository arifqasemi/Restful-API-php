<?php

$payload = [
    "id" => $user["id"],
    "name" => $user["name"],
    "exp"=> time() + 4000
];

$codec = new JWTCodec($secret_key);



$access_token = $codec->encode($payload);

$refresh_token = $codec->encode([
    "id" => $user["id"],
    "exp" => time() + $expiry
]);

echo json_encode([
    "access_token" => $access_token,
    "refresh_token" => $refresh_token
]);


