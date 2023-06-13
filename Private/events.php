<?php

include "util.php";
include "UserController.php";
include "EventController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strtoupper($requestMethod) !== 'POST') {
    $this->fail(405);
}


$filterLevel = $_POST['filter_level'] ?? null;

if ($filterLevel === null) {
    failWithCode(400);
}


if (!in_array($filterLevel, ['faculty', 'degree', 'course', 'all'])) {
    failWithCode(400);
}

$authToken = getAuthToken();

$profileController = new UserController();
$profileResult = $profileController->getUserByUsername($authToken);

if($profileResult == null)
    failWithCode(401);

$eventController = new EventController();
$eventsResult = $eventController->getEventsFiltered($user, $filterLevel); // deprecated

if ($eventsResult == null) {
    echo(json_encode(["status" => "No events found"]));
}else{
    http_response_code(200);
    echo (json_encode(["status" => "success", "data" => $eventsResult]));
}



