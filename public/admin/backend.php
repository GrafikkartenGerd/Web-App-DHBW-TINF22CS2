<?php

function failWithCode($code)
{
    http_response_code($code);
    exit();
    return null;
}

require "auth.php";
require_once("../../private/UserController.php");
require_once("../../private/EventController.php");

header('Content-type: application/json');
$action = $_GET['action'];

// Handle the search users action
if ($action === 'searchEvent') {
  $query = $_GET['query'];

  $controller = new EventController();
  $result = $controller->searchEvents($query);

  if($result == null)
      echo json_encode(['success' => false]);
  else
      echo json_encode(['success' => true, 'events' => $result], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

  exit;
}

// Handle the search users action
if ($action === 'searchUsers') {
    $query = $_GET['query'];

    $controller = new UserController();
    $result = $controller->searchUsers($query);

    if($result == null)
        echo json_encode(['success' => false]);
    else
        echo(json_encode(['success' => true, 'users' => $result, 'is_self_super_admin' => $_SESSION["is_super_admin"]], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP));
    exit;
}

// Handle the delete user action
if ($action === 'deleteUser') {
  $username = $_GET['username'];
  if(!isset($username)) failWithCode(405);
  $controller = new UserController();
  $user = $controller->getUserByUsername($username);

  if($user == null){
    echo json_encode(['success' => false, 'reason' => "User not found!"]);
    exit;
  }

  if($user["is_super_admin"] == 1){
    echo json_encode(['success' => false, 'reason' => "Unable to delete super admin!"]);
    exit;
  }

  $eventController = new EventController();
  $userEvents = $eventController->getEventsByUser($user["id"]);

  foreach($userEvents as $event){
    // This could be done in a single DB query but whatever
    $eventController->deleteEvent($event["id"]);
  }

  $result = $controller->deleteUser($user["id"]);
  echo json_encode(['success' => $result]);
  
  exit;
}

// Handle the delete event action
if ($action === 'deleteEvent') {
  $eid = $_GET['eventId'];
  if(!isset($eid)) failWithCode(405);

  $controller = new EventController();
  $event = $controller->getEventById($eid);
  if($event == null){
    echo json_encode(['success' => false, 'reason' => "Event not found!"]);
    exit;
  }

  $result = $controller->deleteEvent($event["id"]);
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

  if($user["is_super_admin"] == 1){
    echo json_encode(['success' => false, 'reason' => "Unable to change super admin password!"]);
    exit;
  }

  $result = $controller->setUserPassword($user["id"], $newPassword);
  echo json_encode(['success' => $result, 'password' => $newPassword]);
  
  exit;
}

// Handle the promote/demote user
if ($action === 'userPerms') {
  $username = $_GET['username'];
  $promote = $_GET['promote'];

  $controller = new UserController();
  $user = $controller->getUserByUsername($username);

  if($user == null){
    echo json_encode(['success' => false, 'reason' => "User not found!"]);
    exit;
  }

  if($user["is_super_admin"] == 1){
    echo json_encode(['success' => false, 'reason' => "Unable to change super admin permissions!"]);
    exit;
  }

  $result = $controller->changeUserLevel($user["id"], $promote);
  echo json_encode(['success' => $result]);
  
  exit;
}

if ($action === 'getEventList') {

    $controller = new EventController();
    $userController = new UserController();
    $events = $controller->searchEvents("");
    
    foreach ($events as &$event) {
        $hostId = $event['host']; // Assuming 'host' is the key for the host ID in the event array
        $user = $userController->getUserById($hostId);
        if($user == null)
            $event["host"] = "Unknown";
        else
            $event['host'] = $user["username"];
      }

    if($events === null)
        echo json_encode(['status' => false]);
    else
        echo json_encode(['status' => true, 'events' => $events], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

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
