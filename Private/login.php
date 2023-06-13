<?php

include "util.php";
include "AuthController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];
        
if (strtoupper($requestMethod) !== 'POST') failWithCode(405);
if (!isset($_POST["username"]) || !isset($_POST["password"])) failWithCode(400);
        
$username = $_POST["username"];
$password = $_POST["password"];

$controller = new AuthController();
$result = $controller->login($username, $password);
if ($result != "") {
    http_response_code(200);
    
    echo(json_encode([ 'token' => $result]));
}
?>