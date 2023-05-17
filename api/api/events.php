<?php

include "util.php";
include "ProfileController.php";
include "EventController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

# check if the request is valid and has all parameters
if (strtoupper($requestMethod) !== 'POST') {
    $this->fail(405);
}


$filterLevel = $_POST['filter_level'] ?? null;

// check for all required parameters
if ($filterLevel === null) {
    failWithCode(400);
}


if (!in_array($filterLevel, ['faculty', 'degree', 'course', 'all'])) {
    failWithCode(400);
}

$authToken = getAuthToken();

$profileController = new ProfileController();
$profileResult = $profileController->getProfile($authToken);

if($profileResult == null)
    failWithCode(401);

$eventController = new EventController();
$eventsResult = $eventController->getEventsforUser($profileResult, $filterLevel);

if ($eventsResult == null) {
    echo(json_encode(["status" => "No events found"]));
}else{
    http_response_code(200);
    echo (json_encode(["status" => "success", "data" => $eventsResult]));
}



