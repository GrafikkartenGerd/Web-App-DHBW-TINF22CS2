<?php
include "auth.php";
require_once "../private/EventController.php";

$controller = new EventController();

if(!isset($_GET["id"]))
  $controller->fail(404);

$event = $controller->getEventById($_GET["id"]);

if($event == null)
  $controller->fail(404);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  header('Content-type: application/json');

  $accept = $_POST['accept'] ?? null;
  $delete = $_POST['delete'] ?? null;
  if($accept != null){

      $_accept = filter_var($accept, FILTER_VALIDATE_BOOLEAN);
      if($_accept == true)
          $controller->userAcceptEvent($event, $_SESSION["user"]["id"]);
        else
          $controller->userDeclineEvent($event, $_SESSION["user"]["id"]);
        
      http_response_code(200);
      echo(json_encode(["status" => true]));   // assuming it doesnt matter if this fails
  } 
  else if($delete != null){
      $_delete = filter_var($delete, FILTER_VALIDATE_BOOLEAN);
      if($delete){

        if($_SESSION["user"]["id"] == $event["host"]){
          $success = $controller->deleteEvent($event["id"]);

          if($success == false)
            echo(json_encode(["status" => false, "reason" => "Internal server error."]));
          else
            echo(json_encode(["status" => true]));          
        }else{
          echo(json_encode(["status" => false, "reason" => "User does not match host."]));
        }
      }

  }

  exit;
}

$participantIds = $controller->getParticipants($event);
$participants = [];

require_once "../private/UserController.php";
$userController = new UserController();

$eventHost = $userController->getUserById($event["host"]);
if($eventHost == null)
  $eventHost = ["username" => "Unknown", "profile_picture" => DEFAULT_PROFILE_PICTURE, "id" => $event["host"]];

if($participantIds != null){
  foreach ($participantIds as $uid){
    $user = $userController->getUserById($uid);

    if($user !== null)
      $participants[] = $user;
  }
}

$participationStatus = $controller->userEventAcceptanceStatus($event, $_SESSION["user"]["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($event) ? $event['name'] : 'Event'; ?></title>
  <!-- Include Bootstrap CSS and any other necessary CSS files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <script src="util.js"></script>
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <style>
    .event-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
  
    .event-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        margin-bottom: 10px;
    }
  
    .event-name {
        font-weight: bold;
        margin-bottom: 5px;
    }
  
    .event-caption {
        margin-bottom: 10px;
        overflow-wrap: anywhere;
      word-wrap: break-word;
      word-break: normal;
      hyphens: auto;
      white-space: pre-wrap;
    }
  
    .event-date {
        font-size: 14px;
        margin-bottom: 5px;
    }
  
    .event-place {
        font-size: 14px;
        color: #888;
    }
  
    .participants-list {
        margin-top: 20px;
    }
  
</style>
</head>
<body>
  <?php include("../private/header.php"); ?>
  <main>
  <div class="container mt-4">
    <div id="alertContainer"></div>
    <div class="row">
      <div class="col">
        <?php if (isset($event)): ?>
          <h3><?php echo $event['name']; ?></h3>
          <div class="event-caption"><?php echo $event['content']; ?></div>
      
          <div class="d-flex align-items-center">
        <img src="<?php echo $eventHost["profile_picture"]?>" alt="User Profile Picture" class="rounded-circle" style="width: 20px;">
        <a class="mb-0 ml-2" style="margin-left:7px" href="user.php?id=<?php echo $eventHost["id"]?>"><?php echo $eventHost["username"]?></a>
      </div>
          <div class="d-flex align-items-center mt-2">
        <i class="far fa-calendar-alt"></i>
        <p class="mb-0 ml-2" style="margin-left:7px"><?php echo $event["date"]?></p>
      </div>
          <div class="d-flex align-items-center">
            <i class="fas fa-map-marker-alt"></i>
            <p class="mb-0 ml-2" style="margin-left:7px"><?php echo $event['place']; ?></p>
        </div>
          <?php
            if($_SESSION["user"]["id"] == $event["host"]){
              echo '<button class="btn btn-danger" type="button" style="margin-top:10px" onclick="deleteEvent('.$event["id"].')">Delete Event</button>';
            }
          ?>
        <?php if ($event["host"] != $_SESSION["user"]["id"]): ?>
        <div style="margin-top:10px">
          <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" <?php if($participationStatus == 1) echo "checked"?> onclick="changeEventStatus(true);">
          <label class="btn btn-outline-success" for="success-outlined">Join</label>

          <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off" <?php if($participationStatus == 2) echo "checked"?> onclick="changeEventStatus(false);">
          <label class="btn btn-outline-danger" for="danger-outlined">Decline</label>
        </div>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col">
        <h4>Participants (<?php echo count($participants)?>):</h4>
        <ul class="participant-list">
          <?php foreach ($participants as $participant): ?>
            <div class="d-flex align-items-center">
              <img src="<?php echo $participant["profile_picture"]?>" alt="Profile Picture" class="rounded-circle" style="width: 20px;">
              <a class="mb-0 ml-2" style="margin-left:7px" href="user.php?id=<?php echo $participant["id"]?>"><?php echo $participant["username"]?></a>
            </div>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col">
        <button class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy Event URL" onclick="copyEventUrl(this);">
          <i class="fas fa-share"></i> Share
        </button>
      </div>
    </div>
  </div>
</main>

<script>

  window.eventId=<?php echo $event["id"]?>

  function copyEventUrl(sender){
    sender.className = "btn btn-success";
    var fa = sender.querySelector("i");
    fa.className = "fas fa-check";
    sender.innerHTML = fa.outerHTML + " Copied URL to clipboard";
    navigator.clipboard.writeText(window.location.href);
  }

  <?php if($_SESSION["user"]["id"] == $event["host"]): ?>
    function deleteEvent(id){
       $.post('event.php?id=' + id, { delete: true }, function(response) {
          if(!response.status)
            showAlert(response.reason, "danger");
          else
            window.location.href = "index.php";
      });
    }
  <?php endif; ?>

  function changeEventStatus(accept){
    $.post('event.php?id=' + window.eventId, { accept: accept }, function(response) {
      window.location.reload();
      });
  }

</script>

<?php
  include("../private/footer.php");
?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
