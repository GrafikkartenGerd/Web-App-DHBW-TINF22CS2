<?php

include "auth.php"

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CampusConnect</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="swipe.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <style>
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
  <div id="alertContainer"></div>
  <div class="card" id="eventCard" style="display: none;">
  </div>
</div>
  </main>
<?php
    include("../private/footer.php");
?>
<canvas id="confetti-canvas"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/confetti-js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="util.js"></script>
<script src="swipe.js"></script>

<script>
function fetchNextEvent() {
  $.get('fetchEvents.php?filter=next')
    .done(function(response) {
      if(response.success){
        var nextEvent = response.events[0];
        populateEventCard(nextEvent);
      }
      else{
        if(response.reason.includes("No events available"))
          showAlert("There are no events available for you right now, please return later :)", "success");
        else
          showAlert("Failed to get events: " + response.reason, "danger");
      }
    })
    .fail(function() {
      showAlert("Failed to get events!", "danger");
    });
}

// Function to populate the event card with data
function populateEventCard(event) {
  var eventCard = document.getElementById('eventCard');
  window.event = event;
  var user = event.host;
  // Update the card content with the retrieved data
  eventCard.innerHTML = `
    <div class="card-body">
      <a href="event.php?id=${event.id}"><h5 class="card-title">${event.name}</h5></a>
      <p class="card-text">${event.content}</p>
      <div class="d-flex align-items-center">
        <img src="${user.profile_picture}" alt="User Profile Picture" class="rounded-circle" style="width: 20px; height:20px; object-fit:cover">
        <a class="mb-0 ml-2" style="margin-left:7px" href="user.php?id=${user.id}">${user.username}</a>
      </div>
      <div class="d-flex align-items-center mt-2">
        <i class="far fa-calendar-alt"></i>
        <p class="mb-0 ml-2" style="margin-left:7px">${event.date}</p>
      </div>
      <div class="d-flex align-items-center">
        <i class="fas fa-map-marker-alt"></i>
        <p class="mb-0 ml-2" style="margin-left:7px">${event.place}</p>
      </div>
      <div class="d-flex align-items-center">
        <i class="fas fa-user"></i>
        <p class="mb-0 ml-2" style="margin-left:7px">Participants: ${event.participant_count}</p>
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
