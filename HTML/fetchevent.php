<?php
    // TODO auth

require_once("../api/UserController.php");
require_once("../api/EventController.php");

header('Content-type: application/json');

$userController = new UserController();
$userAccount = $userController->getUserByUsername("johndoe");

$eventController = new EventController();
$events = $eventController->getEventsforUser($userAccount, "all");

if($events == null){
    echo json_encode(['success' => false, 'reason' => "Unable to query events!"]);
    exit;
}else if(count($events) == 0){
    echo json_encode(['success' => false, 'reason' => "No events available, please return at a later point."]);
    exit;
}

echo json_encode(['success' => true, 'event' => $events[0], 'host' => $userController->getUserById($events[0]["host"], true)]);
?>