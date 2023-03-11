<?php

declare(strict_types=1);

require __DIR__ . "/bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    
    http_response_code(405);
    header("Allow: POST");
    exit;
}

$data = (array) json_decode(file_get_contents("php://input"), true);

if ( ! array_key_exists("username", $data) ||
     ! array_key_exists("password", $data)) {

    http_response_code(400);
    echo json_encode(["message" => "missing login credentials"]);
    exit;
}
$database = new Database("localhost", "restful_api", "root", "");
$user_gateway = new UserGateway($database);
$user = $user_gateway->getByUsername($data["username"]);

if ($user === false) {
    
    http_response_code(401);
    echo json_encode(["message" => "invalid authentication"]);
    exit;
}

if ( ! password_verify($data["password"], $user["password_hash"])) {
    
    http_response_code(401);
    echo json_encode(["message" => "invalid authentication"]);
    exit;
}

$payload = [
    "id" => $user["id"],
    "name" => $user["name"]
];

$secret_key ="5A7134743777217A25432646294A404E635266556A586E3272357538782F413F";
$codec = new JWTCodec($secret_key);



$access_token = $codec->encode($payload);

echo json_encode([
    "access_token" => $access_token
]);
