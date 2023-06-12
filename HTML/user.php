<?php
  require "auth.php";

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

  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="profile_picture.jpg" class="rounded-circle profile-picture img-fluid" alt="Profile Picture">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h2 class="card-title">John Doe</h2>
                <div class="row">
                  <div class="col-md-4">
                    <p><strong>Faculty:</strong> Engineering</p>
                  </div>
                  <div class="col-md-4">
                    <p><strong>Degree:</strong> Computer Science</p>
                  </div>
                  <div class="col-md-4">
                    <p><strong>Course:</strong> Web Development</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p><strong>Birthdate:</strong> January 1, 1990</p>
                  </div>
                </div>
                <p><strong>Bio:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ultricies sapien at justo ultrices, ut commodo felis semper.</p>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
