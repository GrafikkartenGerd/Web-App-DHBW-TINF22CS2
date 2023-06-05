<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Connect</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="swipe.css">
  <!-- Include custom CSS -->
  <style>
    .card {
      margin-bottom: 20px;
    }

    .navbar-icon {
  width: 55px; 
}
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <img src="logo.png" alt="Campus Connect Icon" class="navbar-icon">
    Campus Connect
  </a>
  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Announcements</a>
      </li>
    </ul>
  </div>
  <div class="navbar-nav ml-auto pr-2 d-none d-lg-block">
    <a class="nav-link" href="#">
      <img src="profile_picture.jpg" alt="Profile Picture" class="rounded-circle" style="width: 55px; padding-left:10px; padding-right:10px">
    </a>
  </div>
</nav>

<style>
  @media (max-width: 991.98px) {
    .navbar-toggler {
      margin-left: auto !important;
      margin-right: 0.5rem !important;
    }
    .navbar-nav.ml-auto:not(.collapse) {
      display: flex !important;
    }
    .navbar:not(.navbar-expand-lg) {
      padding-right: 1rem;
    }
    .navbar-collapse {
      padding-left: 1rem;
    }
  }
</style>

<script>
  document.querySelector('.navbar-toggler').addEventListener('click', function() {
    document.querySelector('.navbar-collapse').classList.toggle('show');
  });
</script>

<div id="alertContainer"></div>
<div class="container mt-4">
  <div class="card" id="eventCard" style="display: none;">
  </div>
</div>

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

<script>

</script>


</body>
</html>
