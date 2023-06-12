<?php

include "auth.php"

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CampusConnect</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="swipe.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <!-- Include custom CSS -->
  <style>
    .card {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<?php
  include("header.php");
?>

<div class="container mt-4">
  <div id="alertContainer"></div>
  <div class="card" id="eventCard" style="display: none;">
  </div>
</div>
<?php
    include("footer.php");
?>
<canvas id="confetti-canvas"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/confetti-js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="util.js"></script>
<script src="swipe.js"></script>

<script>
function fetchNextEvent() {
  $.get('fetchEvent.php')
    .done(function(response) {
      if(response.success)
        populateEventCard(response);
      else
        showAlert("Failed to get events: " + response.reason, "danger");
    })
    .fail(function() {
      showAlert("Failed to get events!", "danger");
    });
}

// Function to populate the event card with data
function populateEventCard(data) {
  var eventCard = document.getElementById('eventCard');
  var event = data.event;
  var user = data.host;
  // Update the card content with the retrieved data
  eventCard.innerHTML = `
    <div class="card-body">
      <h5 class="card-title">${event.name}</h5>
      <p class="card-text">${event.content}</p>
      <div class="d-flex align-items-center">
        <img src="${user.profile_picture}" alt="User Profile Picture" class="rounded-circle" style="width: 20px;">
        <p class="mb-0 ml-2" style="margin-left:7px">${user.username}</p>
      </div>
      <div class="d-flex align-items-center mt-2">
        <i class="far fa-calendar-alt"></i>
        <p class="mb-0 ml-2" style="margin-left:7px">${event.date}</p>
      </div>
      <div class="d-flex align-items-center">
        <i class="fas fa-map-marker-alt"></i>
        <p class="mb-0 ml-2" style="margin-left:7px">${event.place}</p>
      </div>
    </div>
  `;

  // Show the event card
  eventCard.style.display = 'block';
}
</script>

<script>
  fetchNextEvent();
</script>

</body>
</html>
