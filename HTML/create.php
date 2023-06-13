<?php

include "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $eventName = isset($_POST['eventName']) ? $_POST['eventName'] : null;
  $eventDate = isset($_POST['date']) ? $_POST['date'] : null;
  $eventPlace = isset($_POST['place']) ? $_POST['place'] : null;
  $eventContent = isset($_POST['content']) ? $_POST['content'] : null;

  if ($eventName !== null && !empty($eventName) &&
      $eventDate !== null && !empty($eventDate) &&
      $eventPlace !== null && !empty($eventPlace) &&
      $eventContent !== null && !empty($eventContent)) {
      
      // Validate event date
      $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $eventDate);

      if($dateTime < new DateTime())
        $errorMessage = "Date is in the past.";
      else{

        if ($dateTime !== false) {
        
          require_once "../api/EventController.php";

          $controller = new EventController();
          $result = $controller->createEvent($eventName, $dateTime, $eventPlace, $eventContent, $_SESSION["user"]["faculty"], $_SESSION["user"]["degree"], $_SESSION["user"]["course"], $_SESSION["user"]["stuv"], $_SESSION["user"]["id"]);

          if($result == false)
            $errorMessage = "Internal server error.";

          else
            header("Location: event.php?id=".$result);

        } else {
            $errorMessage = "Invalid date format.";
        }
      }
  } else {
      $errorMessage = "Please fill in all required fields";
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Event - CampusConnect</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    .card {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<?php
  include "header.php";
?>

<main>
<div id="alertContainer"></div>

<div class="container mt-4">
<div id="alertContainer">
                    <?php
                        if(isset($errorMessage))
                            echo '<div role="alert" class="alert alert-danger">'.$errorMessage.'</div>';
                    ?>
                </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Create Event</h5>
      <form method="POST" action="create.php">
        <div class="mb-3">
          <label for="eventName" class="form-label">Event Name</label>
          <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Enter event name" required>
        </div>
        <div class="mb-3">
          <label for="eventDate" class="form-label">Event Date</label>
          <input type="datetime-local" class="form-control" name="date" id="eventDate" required>
        </div>
        <div class="mb-3">
          <label for="eventPlace" class="form-label">Event Place</label>
          <input type="text" class="form-control" id="eventPlace" name="place" placeholder="Enter event place" required>
        </div>
        <div class="mb-3">
          <label for="eventContent" class="form-label">Event Content</label>
          <textarea class="form-control" id="eventContent" rows="3" name="content" placeholder="Enter event content" required></textarea>
        </div>
        <div class="mb-3">
          <label for="eventPoster" class="form-label">Event Poster</label>
          <input type="file" class="form-control" id="eventPoster" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
    </div>
  </div>
</div>
  </main>

<?php
  include("footer.php");
?>
<!-- Include Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

