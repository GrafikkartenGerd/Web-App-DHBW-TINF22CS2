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

<style>
  .swipeable-card {
    position: relative;
    cursor: grab;
    transition: transform 0.3s;
  }

  .swipeable-card.swipe-left {
    transform: translateX(-100%);
  }

  .swipeable-card.swipe-right {
    transform: translateX(100%);
  }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.10/sweetalert2.min.js"></script>
<script>
  // Add swipe functionality to the event card
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
    } else if (deltaX > threshold) {
      eventCard.classList.add('swipe-right');
      showConfettiAndPlaySound();
    }
  });

  function showConfettiAndPlaySound() {
    // Show confetti explosion animation
    Swal.fire({
      title: 'Swiped Right!',
      html: '<div id="confetti-container"></div>',
      showConfirmButton: false,
      background: 'transparent',
      allowOutsideClick: false,
      onOpen: () => {
        var confettiContainer = document.getElementById('confetti-container');
        var confettiSettings = { target: confettiContainer, max: 200 };
        var confetti = new ConfettiGenerator(confettiSettings);
        confetti.render();
      },
      onClose: () => {
        // Play calming chime sound
        var audio = new Audio('calming_chime_sound.mp3');
        audio.play();
      }
    });
  }
</script>


</body>
</html>
