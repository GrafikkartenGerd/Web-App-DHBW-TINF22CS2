<?php

require_once "auth.php";

if(!isset($_GET["username"])){
    http_response_code(405);
    exit;
}

require_once "../api/UserController.php";

$username = $_GET['username'];
$controller = new UserController();
$user = $controller->getUserByUsername($username);

if($user == null){
    http_response_code(404);
    exit;
}
$jsonString = json_encode($user, JSON_PRETTY_PRINT);
header('Content-Disposition: attachment; filename="'.$username.'.json"');
header('Content-Type: text/plain'); # Don't use application/force-download - it's not a real MIME type, and the Content-Disposition header is sufficient
header('Content-Length: ' . strlen($jsonString));
header('Connection: close');
echo($jsonString);
?>