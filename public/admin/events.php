<?php
  require "auth.php";
  require_once "../../private/UserController.php";
  require_once "../../private/EventController.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  
  <link
      href="https://code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css"
      rel="stylesheet"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="header.css">
  <title>CampusConnect Admin - Events</title>
</head>

<body>

<?php
  include "../../private/admin_header.php";
?>

  <div class="container mt-4">
   <div id="alertContainer"></div>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">User Count</h5>
            <p class="card-text">Total number of users: <span id="userCount">
              <?php
                 $controller = new UserController();
                 $userCount = $controller->getUserCount();
                 echo($userCount);
              ?>
            </span></p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Current Events</h5>
            <p class="card-text">Number of current events: <span id="eventCount">
            <?php
                 $controller = new EventController();
                 $userCount = $controller->getEventCount();
                 echo($userCount);
              ?>
            </span></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-4">
  <div class="tab-content">
    <div class="tab-pane fade show active" id="events">
      <h3>Events</h3>
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search events" id="searchEventInput">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit" id="searchEventsButton">Search</button>
        </div>
      </div>
      <table class="table">
        <thead>
        <tr>
              <th>Name</th>
              <th>Location</th>
              <th>Host</th>
              <th>Date-time</th>
              <th>Actions</th>
            </tr>
        </thead>
        <tbody id="eventsTableBody">
        </tbody>
      </table>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="js/util.js"></script>
  <script src="js/events.js"></script>
</body>
</html>
