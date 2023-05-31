<?php

require_once("../api/UserController.php");
require_once("../api/EventController.php");

header('Content-type: application/json');
$action = $_GET['action'];

// Handle the search users action
if ($action === 'searchUsers') {
    $query = $_GET['query'];

    $controller = new UserController();
    $result = $controller->searchUsers($query);

    if($result == null)
        echo json_encode(['success' => false]);
    else
        echo json_encode(['success' => true, 'users' => $result]);

    exit;
}

// Handle the delete user action
if ($action === 'deleteUser') {
  $username = $_GET['username'];

  $controller = new UserController();
  $user = $controller->getUserByUsername($username);
  if($user == null){
    echo json_encode(['success' => false, 'reason' => "User not found!"]);
    exit;
  }

  $result = $controller->deleteUser($user["id"]);
  echo json_encode(['success' => $result]);
  
  exit;
}

// Handle the reset password action
if ($action === 'resetPassword') {
  $username = $_GET['username'];

  $newPassword = generateNewPassword();

  $controller = new UserController();
  $user = $controller->getUserByUsername($username);
  if($user == null){
    echo json_encode(['success' => false, 'reason' => "User not found!"]);
    exit;
  }

  $result = $controller->setUserPassword($user["id"], $newPassword);
  echo json_encode(['success' => $result, 'password' => $newPassword]);
  
  exit;
}

if ($action === 'statistics') {
    $controller = new UserController();
    $userCount = $controller->getUserCount();
    $controller = new EventController();
    $eventsCount = $controller->getEventCount();
    
    echo json_encode(['eventsCount' => $eventsCount, 'userCount' => $userCount]);

    exit;
}

if ($action === 'getEventList') {

    $controller = new EventController();
    $userController = new UserController();
    $events = $controller->getEventsforUser(null, "all");
    
    foreach ($events as &$event) {
        $hostId = $event['host']; // Assuming 'host' is the key for the host ID in the event array
        $user = $userController->getUserById($hostId);
        if($user == null)
            $event["host"] = "Unknown";
        else
            $event['host'] = $user["username"];
      }

    if($events == null)
        echo json_encode(['status' => false]);
    else
        echo json_encode(['status' => true, 'events' => $events]);

    exit;
}

function generateNewPassword() {
  
  $abc = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $password = '';
  $length = 16;

  for ($i = 0; $i < $length; $i++) {
    $index = rand(0, strlen($abc) - 1);
    $password .= $abc[$index];
  }

  return $password;
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
exit;
?>
