<?php

include "auth.php";

$scope = $_GET['scope'] ?? null;
if($scope == null) $scope = "upcoming";

require_once "../private/EventController.php";
require_once "../private/UserController.php";

$controller = new EventController();
$events = $controller->getEventsFiltered($_SESSION["user"], $scope);

if($events === null)
  $errorMessage = "Internal server error.";

$userController = new UserController();

foreach ($events as &$event) {
  $hostId = $event['host']; // Assuming 'host' is the key for the host ID in the event array
  $user = $userController->getUserById($hostId, true);    // get minimal info to prevent data leaks
  if($user == null)
      $event["host"] = ["username" => "Unknown", "profile_picture" => DEFAULT_PROFILE_PICTURE, "id" => $hostId];
  else
      $event['host'] = $user;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Timeline</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="footer.css">
  <style>

    .event-timeline {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .event-box {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 20px;
      width: 80%;
      margin-left: auto;
      margin-right: auto;
    }

    .event-box img {
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

    .card {
      margin-bottom: 20px;
    }

    .card-text {
      overflow-wrap: anywhere;
      word-wrap: break-word;
      word-break: normal;
      hyphens: auto;
      white-space: pre-wrap;
    }

    </style>
</head>
<body>

<?php
  include("../private/header.php");
?>
<main>
<div class="container mt-4">
  <div id="alertContainer">
                    <?php
                        if(isset($errorMessage))
                            echo '<div role="alert" class="alert alert-danger">'.$errorMessage.'</div>';
                    ?>
                </div>
  <div class="row event-timeline">
    <div class="col">
      <h3>Event Timeline</h3>
      <div class="dropdown mb-3">
        <button class="btn btn-primary dropdown-toggle" type="button" id="scopeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Select Scope
        </button>
        <ul class="dropdown-menu" aria-labelledby="scopeDropdown">
        <li><button type="button" class="dropdown-item" href="#" onclick="changeScope('upcoming')">Upcoming</button></li>
          <li><button type="button" class="dropdown-item" href="#" onclick="changeScope('today')">Today</button></li>
          <li><button type="button" class="dropdown-item" href="#" onclick="changeScope('past')">Past</button></li>
          <li><button type="button" class="dropdown-item" href="#" onclick="changeScope('joined')">Joined</button></li>
          <li><button type="button" class="dropdown-item" href="#" onclick="changeScope('declined')">Declined</button></li>
        </ul>
      </div>
      <div id="eventTimeline">
           <?php foreach ($events as $event): $eventHost = $userController->getUserById($event["id"]);?>
            <?php  ?>
            <div class="card">
              <div class="card-body">
                  <a href="event.php?id=<?php echo $event["id"]?>"><h5 class="card-title"><?php echo htmlspecialchars($event["name"], ENT_QUOTES, 'UTF-8');?></h5></a>
                  <p class="card-text"><?php echo htmlspecialchars($event["content"], ENT_QUOTES, 'UTF-8')?></p>
                   <div class="d-flex align-items-center">
                        <img src="<?php echo htmlspecialchars($event["host"]["profile_picture"], ENT_QUOTES, 'UTF-8');?>" alt="User Profile Picture" class="rounded-circle" style="width: 20px;">
                        <a class="mb-0 ml-2" style="margin-left:7px" href="user.php?id=<?php echo $event["host"]["id"]?>"><?php echo htmlspecialchars($event["host"]["username"], ENT_QUOTES, 'UTF-8');?></a>
                      </div>
                  <div class="d-flex align-items-center mt-2">
                    <i class="far fa-calendar-alt"></i>
                    <p class="mb-0 ml-2" style="margin-left:7px"><?php echo htmlspecialchars($event["date"], ENT_QUOTES, 'UTF-8');?></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-map-marker-alt"></i>
                    <p class="mb-0 ml-2" style="margin-left:7px"><?php echo htmlspecialchars($event["place"], ENT_QUOTES, 'UTF-8')?></p>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-user"></i>
                    <p class="mb-0 ml-2" style="margin-left:7px">Participants: <?php echo count($controller->getParticipants($event))-1?></p>
                  </div>
                    <button class="btn btn-primary" type="button" onclick="copyEventUrl(this, <?php echo $event['id']; ?>);" style="margin-top:10px">
                      <i class="fas fa-share"></i> Share
                    </button>
              </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>

 function copyEventUrl(sender, id){
    sender.className = "btn btn-success";
    var fa = sender.querySelector("i");
    fa.className = "fas fa-check";
    sender.innerHTML = fa.outerHTML + " Copied URL to clipboard";
    var relativeUrl = "event.php?id=" + id;
    var absoluteUrl = new URL(relativeUrl, window.location.href).href;
    navigator.clipboard.writeText(absoluteUrl);
  }

  function changeScope(scope){
    window.location.href = "timeline.php?scope=" + scope;
  }

</script>
<?php
  include("../private/footer.php")
?>
</body>
</html>

