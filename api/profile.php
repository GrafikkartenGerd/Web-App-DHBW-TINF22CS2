<?php

include "util.php";
include "UserController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strtoupper($requestMethod) !== 'POST') {
    $this->fail(405);
}

$authToken = getAuthToken();
$controller = new UserController();
$result = $controller->getUserByUsername($authToken);

if($result == null)
    echo (json_encode(["status" => false]));

http_response_code(200);
echo (json_encode(["status" => true, "data" => $result]));


?>
