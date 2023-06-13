<?php
  require "auth.php";

  require_once "../private/UserController.php";
  require_once "../private/EventController.php";

  $uid = $_GET['id'] ?? null;

  if($uid == null)
    $uid = $_SESSION["user"]["id"];

  $controller = new UserController();
  $userInfo = $controller->getUserById($uid, true);

  $eventController = new EventController();
  $userEvents = $eventController->getEventsByUser($uid);

  if($userInfo == null){
    $controller->fail(404);
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $userInfo["username"]; ?> - CampusConnect</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <style>
    .profile-picture {
      width: 250px;
      height: 250px;
      padding: 12px;
      object-fit: cover;
    }

    .card {
      margin-bottom: 20px;
    }

  </style>
</head>
<body>

<?php
  include "../private/header.php";
?>
<main>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="<?php echo $userInfo["profile_picture"]?>" class="rounded-circle profile-picture img-fluid" alt="Profile Picture">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h2 class="card-title"><?php echo $userInfo["name"]." ".$userInfo["surname"]?></h2>
                <p><?php echo $userInfo["username"]?></p>
                <div class="row">
                  <div class="col-md-4">
                    <p><strong>Course:</strong> <?php echo $userInfo["course"]?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p><strong>Birthday:</strong> <?php echo $userInfo["birthday"]?></p>
                  </div>
                </div>
                <p><strong>Bio:</strong> <?php echo $userInfo["bio"]?></p>
                <div class="d-flex justify-content-end">
                <?php

                  if($_SESSION["user"]["id"]==$userInfo["id"]){
                    echo '<a class="btn btn-primary" href="profile.php">Edit Profile</a>';
                  }
                    ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <h3>Events Created (<?php echo count($userEvents)?>):</h3>
        <?php foreach ($userEvents as $event): ?>
          <div class="card">
          <div class="card-body">
              <a href="event.php?id=<?php echo $event["id"]?>"><h5 class="card-title"><?php echo $event["name"]?></h5></a>
              <p class="card-text"><?php echo $event["content"]?></p>
              <div class="d-flex align-items-center mt-2">
                <i class="far fa-calendar-alt"></i>
                <p class="mb-0 ml-2" style="margin-left:7px"><?php echo $event["date"]?></p>
              </div>
              <div class="d-flex align-items-center">
                <i class="fas fa-map-marker-alt"></i>
                <p class="mb-0 ml-2" style="margin-left:7px"><?php echo $event["place"]?></p>
              </div>
              <div class="d-flex align-items-center">
                <i class="fas fa-user"></i>
                <p class="mb-0 ml-2" style="margin-left:7px">Participants: <?php echo count($eventController->getParticipants($event))-1?></p>
              </div>
          </div>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
  </div>
  </main>
  <?php
    include("../private/footer.php")
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
