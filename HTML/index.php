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
  <!-- Include custom CSS -->
  <style>
    .card {
      margin-bottom: 20px;
    }

    .navbar-icon {
  width: 55px; /* Adjust the width to your desired size */
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
    <!-- Card content goes here -->
  </div>
</div>

<div class="container mt-4">
  <div class="card" id="eventCard">
    <div class="card-body">
      <h5 class="card-title">Event Name</h5>
      <p class="card-text">Event description goes here...</p>
      <div class="d-flex align-items-center">
        <img src="user_profile_picture.jpg" alt="User Profile Picture" class="rounded-circle" style="width: 20px;">
        <p class="mb-0 ml-2">Event Creator</p>
      </div>
      <div class="d-flex align-items-center mt-2">
        <i class="far fa-calendar-alt"></i>
        <p class="mb-0 ml-2">Event Date and Time</p>
      </div>
      <div class="d-flex align-items-center">
        <i class="fas fa-map-marker-alt"></i>
        <p class="mb-0 ml-2">Event Location</p>
      </div>
    </div>
  </div>
</div>

<canvas id="confetti-canvas"></canvas>

<style>
  .swipeable-card {
    position: relative;
    cursor: grab;
    transition: transform 0.3s;
  }

  .swipeable-card.swipe-left {
    transform: translateX(-100%) rotate(-15deg);
    opacity: 0;
    transition: transform 0.3s, opacity 0.3s;
  }

  .swipeable-card.swipe-right {
    transform: translateX(100%) rotate(15deg);
    opacity: 0;
    transition: transform 0.3s, opacity 0.3s;
  }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/confetti-js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
#confetti-canvas {
  position: fixed;
  top: 0;
  left: 0;
  pointer-events: none; /* Ensure the canvas doesn't interfere with other elements */
  z-index: 9998; /* Place the canvas below the popup */
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7); /* Adjust the opacity to control the darkness */
  z-index: 9997; /* Place the overlay below the popup */
}

.confirmation-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 9999; /* Ensure the popup is on top of other elements */
  background-color: #fff;
  padding: 10px 20px;
  font-size: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.card-particle {
  position: absolute;
  background-color: #000;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  animation-fill-mode: forwards;
}

@keyframes explode {
  to {
    opacity: 0;
    transform: translate3d(calc(50% - 5px), calc(50% - 5px), 0) scale(0.2);
  }
}
</style>

<script>
function fetchNextEvent() {
  // Perform AJAX request to fetch event card data
  // Replace the URL with the actual endpoint to fetch the data
  $.ajax({
    url: 'fetchEvent.php',
    method: 'GET',
    success: function(data) {
      
      populateEventCard(data);
    },
    error: function() {
      console.log('Failed to fetch event card data');
    }
  });
}

// Function to populate the event card with data
function populateEventCard(data) {
  var eventCard = document.getElementById('eventCard');

  // Update the card content with the retrieved data
  eventCard.innerHTML = `
    <div class="card-body">
      <h5 class="card-title">${data.eventName}</h5>
      <p class="card-text">${data.description}</p>
      <div class="d-flex align-items-center">
        <img src="${data.profilePicture}" alt="User Profile Picture" class="rounded-circle" style="width: 20px;">
        <p class="mb-0 ml-2">${data.creator}</p>
      </div>
      <div class="d-flex align-items-center mt-2">
        <i class="far fa-calendar-alt"></i>
        <p class="mb-0 ml-2">${data.dateAndTime}</p>
      </div>
      <div class="d-flex align-items-center">
        <i class="fas fa-map-marker-alt"></i>
        <p class="mb-0 ml-2">${data.location}</p>
      </div>
    </div>
  `;

  // Show the event card
  eventCard.style.display = 'block';
}
</script>

<script>
  var eventCard = document.getElementById('eventCard');
  var mc = new Hammer(eventCard);

  var initialX = null;
  var isSwiping = false;

  mc.on('panstart', function(e) {
    initialX = e.center.x;
    isSwiping = true;
  });

  mc.on('panmove', function(e) {
    if (!isSwiping) return;
    var deltaX = e.deltaX;
    eventCard.style.transform = 'translateX(' + deltaX + 'px)';
  });

  mc.on('panend', function(e) {
    if (!isSwiping) return;
    isSwiping = false;
    eventCard.style.transform = '';

    var deltaX = e.deltaX;
    var threshold = eventCard.offsetWidth * 0.25;

    if (deltaX < -threshold) {
      eventCard.classList.add('swipe-left');
      explodeCard();

    } else if (deltaX > threshold) {
      eventCard.classList.add('swipe-right');
      showConfirmation();
      eventCard.remove();  
    }
  });

  function explodeCard() {
    $(eventCard).hide( "explode", {pieces: 5 }, 200);
  }

  function showConfirmation() {
      // Play chime sound
  var audio = new Audio('chime.mp3');
  audio.play();
  // 
  var confirmationContainer = $('<div>Liked event!</div>')
    .addClass('confirmation-popup')
    .appendTo('body');

     // this will make the background darker temporarly
  var overlay = $('<div></div>')
    .addClass('overlay')
    .appendTo('body');

  // Show confetti
  var confettiSettings = {
    target: 'confetti-canvas',
    max: 100,
    size: 1,
    animate: true
  };
  var confetti = new ConfettiGenerator(confettiSettings);
  confetti.render();

   // add bounce
  confirmationContainer.effect('bounce', { times: 2, distance: 100 }, 750, function() {
    confirmationContainer.remove();
    confetti.clear();
    overlay.remove();
  });
  }
</script>

<script>

</script>


</body>
</html>
