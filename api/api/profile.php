<?php

include "util.php";
include "ProfileController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

# check if the request is valid and has all parameters
if (strtoupper($requestMethod) !== 'POST') {
    $this->fail(405);
}

$authToken = getAuthToken();
$controller = new ProfileController();
$result = $controller->getProfile($authToken);

if($result == null)
    echo (json_encode(["status" => false]));

http_response_code(200);
echo (json_encode(["status" => true, "data" => $result]));


?>
