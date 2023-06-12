<?php
  require "auth.php";

  require_once "../api/UserController.php";

  $uid = $_GET['id'] ?? null;

  if($uid == null)
    $uid = $_SESSION["user"]["id"];

  $controller = new UserController();
  $userInfo = $controller->getUserById($uid, true);

  if($userInfo == null){
    $controller->fail(404);
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <style>
    .profile-picture {
      width: 200px;
      height: auto;
      padding: 12px;
    }
  </style>
</head>
<body>

<?php
  include "header.php";
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <h3>Events Created</h3>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Event 1</h5>
            <p class="card-text">Some description about Event 1.</p>
            <div class="event-details">
              <i class="far fa-calendar-alt"></i> October 10, 2023
              <i class="fas fa-map-marker-alt"></i> Event Location 1
            </div>
          </div>
        </div>

        
      </div>
    </div>
  </div>
  </main>
  <?php
    include("footer.php")
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
