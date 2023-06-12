<?php
include "auth.php";
require_once "../api/EventController.php";

$controller = new EventController();

if(!isset($_GET["id"]))
  $controller->fail(404);

$event = $controller->getEventById($_GET["id"]);

if($event == null)
  $controller->fail(404);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $accept = $_POST['accept'] ?? null;
  if($accept == null)
    exit;

  $_accept = filter_var($accept, FILTER_VALIDATE_BOOLEAN);
  
  if($_accept == true)
    $controller->userAcceptEvent($event, $_SESSION["user"]["id"]);
  else
    $controller->userDeclineEvent($event, $_SESSION["user"]["id"]);

  exit;
}

$participantIds = $controller->getParticipants($event);
$participants = [];

require_once "../api/UserController.php";
$userController = new UserController();

$eventHost = $userController->getUserById($event["host"]);

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
  <?php include("header.php"); ?>
  <main>
  <div class="container mt-4">
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

  function changeEventStatus(accept){
    $.post('event.php?id=' + window.eventId, { accept: accept }, function(response) {
      location.reload();
      });
  }

</script>

<?php
  include("footer.php");
?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
