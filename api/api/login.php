<?php

include "AuthController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];
        
# check if the request is valid and has all parameters
if (strtoupper($requestMethod) !== 'POST') $this->fail(505);
if (!isset($_POST["username"]) || !isset($_POST["password"])) $this->fail(400);
        
$username = $_POST["username"];
$password = $_POST["password"];

$controller = new AuthController();
$result = $controller->login($username, $password);
if ($result != "") {
    http_response_code(200);
    
    # return the auth token
    echo(json_encode([ 'token' => $result]));
}
?>