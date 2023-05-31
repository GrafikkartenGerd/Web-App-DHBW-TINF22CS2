<?php

include "util.php";
include "ProfileController.php";
include "EventController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

# check if the request is valid and has all parameters
if (strtoupper($requestMethod) !== 'POST') {
    $this->fail(405);
}

$name = $_POST['name'] ?? null;
$date = $_POST['date'] ?? null;
$place = $_POST['place'] ?? null;
$content = $_POST['content'] ?? null;
$faculty = $_POST['faculty'] ?? null;
$degree = $_POST['degree'] ?? null;
$course = $_POST['course'] ?? null;
$stuv = $_POST['stuv'] ?? null;

// Check for all required parameters
if (
    $name === null ||
    $date === null ||
    $place === null ||
    $content === null ||
    $faculty === null ||
    $degree === null ||
    $course === null ||
    $stuv === null
) {
    failWithCode(400);
}

$authToken = getAuthToken();

$profileController = new ProfileController();
$profileResult = $profileController->getProfile($authToken);

if($profileResult == null)
    failWithCode(401);

$eventController = new EventController();
$result = $eventController->createEvent($name, $date, $place, $content, $faculty, $degree, $course, $stuv, $profileResult["id"]);

http_response_code(200);
echo (json_encode(["status" => $result]));