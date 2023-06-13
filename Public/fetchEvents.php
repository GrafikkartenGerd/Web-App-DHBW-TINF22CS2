<?php

include "auth.php";

require_once("../private/UserController.php");
require_once("../private/EventController.php");

header('Content-type: application/json');

$userController = new UserController();
$userAccount = $_SESSION["user"];

$filter = $_GET['filter'] ?? null;
if($filter == null)
    $userController->fail(400);

$eventController = new EventController();
$events = $eventController->getEventsFiltered($userAccount, $filter);

if($events === null){
    echo json_encode(['success' => false, 'reason' => "Unable to query events!"]);
    exit;
}else if(count($events) == 0){
    echo json_encode(['success' => false, 'reason' => "No events available."]);
    exit;
}

foreach ($events as &$event) {
        $hostId = $event['host']; // Assuming 'host' is the key for the host ID in the event array
        $user = $userController->getUserById($hostId, true);    // get minimal info to prevent data leaks
        if($user == null)
            $event["host"] = ["username" => "Unknown", "profile_picture" => DEFAULT_PROFILE_PICTURE, "id" => $hostId];
        else
            $event['host'] = $user;
        
        $event["participant_count"] = count($eventController->getParticipants($event)) - 1;
      }

echo json_encode(['success' => true, 'events' => $events]);
?>