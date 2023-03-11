<?php

declare(strict_types=1);

require dirname(__DIR__) . "/api/bootstrap.php";


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[3];

$id = $parts[4] ?? null;

if ($resource != "task") {
    
    http_response_code(404);
    exit;
}



$database = new Database("localhost", "restful_api", "root", "");


$user_gateway = new UserGateway($database);

// $headers = apache_request_headers();
// echo $headers["Authorization"];
// var_dump($_SERVER['HTTP_AUTHORIZATION']);
// echo $headers;
$auth = new Auth($user_gateway);

// $auth->authenticateAccessToken();
// exit;



if ( ! $auth->authenticateAccessToken()) {
    exit;
}

// echo "valid authentication";
// exit;

$user_id = $auth->getUserId();
// $user_id=5;
// print_r($user_id);
$task_gateway = new TaskGateway($database);

$controller = new TaskController($task_gateway,$user_id);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);









