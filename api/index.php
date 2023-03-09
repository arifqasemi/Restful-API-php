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

// $auth = new Auth($user_gateway);
// if(!$auth->authenticationApiKey()){
//     exit;
// }

$task_gateway = new TaskGateway($database);


$controller = new TaskController($task_gateway);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);









